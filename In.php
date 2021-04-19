<?php

class In {
	public $arCusResult=[];
	public $result = [];
	public $head =[];
	private static $instance = null;
	public $tr_head = false;
	public $obLoad;
	public $cbe;
	public $PROP =[];
	public $id_add =[];
	public $iblock_id;
	public $rend;
	public function __construct($path) {
		if(empty($this->iblock_id)){
			$this->iblock_id = 2;
		}
		$a = new CCSVData('R',false);
		$a->LoadFile($path);
		$a->SetDelimiter();
		$j =0;
		while($arRes = $a->Fetch()){
			if(!$this->head){
				for($i = 0; $i < count($arRes); $i++){
					$this->head[] = $arRes[$i];
				}
			}
			else{
				$j++;
				for($i = 0; $i < count($arRes) ;$i++){
					$this->result[$j][$this->head[$i]] = $arRes[$i];
				}

			}
		}
	}
	public static function getInstance($path)
	{

		if (empty(self::$instance))
		{

			require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/csv_data.php");
			self::$instance = new self($path);

		}

		return self::$instance;
	}

	public function init() {
			$_SESSION['data_size']='';
			require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
			CModule::IncludeModule('iblock');
			$this->cbe = new CIBlockElement;

			$this->getElemFromBlock($this->iblock_id);

			if($this->getSize($this->result) == $_SESSION['data_size']=$this->getSize($this->arCusResult)){

			}else{

				$this->delItem($this->arCusResult);


				if($id = $this->addToBlock($this->result,$this->iblock_id)){
					$this->getElemFromBlock($this->iblock_id);

				};
				$_SESSION['data_size']=$this->getSize($this->arCusResult);

			}

	}


	public function getSize($result=[]) {
		if(empty($result)){
			$result = $this->result;
		}
		$h1 = false;
		$str = '';
		foreach($result as $item) {
			if(!$h1) {
				$str = strtolower(implode("", array_keys($item)));
				$h1 = true;
			}
			$str .= strtolower(implode("", $item));
		}

		return mb_strlen($str, '8bit');
	}

	public function addToBlock($result,$iblock_id){

		$id=[];
		foreach($result as $item) { //Вставка из файла в бд


			foreach($item as $key => $value){
				$this->PROP[strtoupper($key)] = $value;
			}
			$fields = [
				"IBLOCK_ID" => $iblock_id,
				"NAME" =>$item["name"],
				"PROPERTY_VALUES" => $this->PROP,
				"ACTIVE" => "Y"
			];
			$id[] = $this->cbe->Add($fields);
		}
		unset($item,$key,$value);
		return $id;


	}

	public function getElemFromBlock($iblock_id){

		$arSelect = ["ID"];
		$arResult = [];
		$arFilter = ["IBLOCK_ID"=> 2, "DATA_ACTIVE_FROM" => "ASC", "ACTIVE" => "Y"];
		$res_i = CIBlockElement::GetList([],$arFilter,false,false,$arSelect);

		while($a = $res_i->GetNextElement()){
			$arFields = $a->GetFields();
			$prop = $this->cbe::GetProperty($iblock_id,$arFields["ID"]);
			$arProps = [];
			while($pr = $prop->GetNext()){
				$arProps[$pr['CODE']] = $pr['VALUE'];
			}

			$arResult[$arFields["ID"]] = $arProps;
		}


		$this->arCusResult = $arResult;

	}

	public function delItem($arr){
		foreach($arr as $key => $value){
			CIBlockElement::Delete($key);
		}
	}

	public function render() {
		$this->rend = '
		<div class="container">
			<div class="row">
				<table>';
		$tr_head = false;
		for($j = 0; $j <= count($this->result); $j++) {

			$this->rend .='<tr>';
						 if(!$tr_head) {
							 foreach($this->head as $value) {
								$this->rend .= '<td>'.$value.'</td>';
							}
							 unset($value);
							 $tr_head = true;

							 continue;
						 }
						 foreach($this->result[$j] as $key => $value) {
							 $this->rend .= '<td>'.$this->result[$j][$key].'</td>';
							}
						}
					unset($key, $value);

					$this->rend .= '</tr>';
		unset($i, $j);
			$this->rend .= '</table>';

			$this->rend .= '</div>';



		$this->rend .= '</div>';
		echo $this->rend;
	}
}