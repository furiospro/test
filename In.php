<?php

class In {
	public $arCusResult=[];
	public $result = [];
	public $head =[];
	public $file = null;
	public $tr_head = false;
	public $obLoad;
	public $cbe;
	public $PROP =[];
	public $id_add =[];
	public $iblock_id;
	public $rend;
	public $time_x;
	public $filemt=null;
	public function __construct($path) {
		require_once ($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/classes/general/csv_data.php");
		$this->filemt = filemtime($path);

		if(empty($this->iblock_id)){
			$this->iblock_id = 2;
		}
		$this->file = new CCSVData('R',false);
		$this->file->LoadFile($path);
		$this->file->SetDelimiter();
		$j =0;
		while($arRes = $this->file->Fetch()){
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

	public function init() {

			require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
			CModule::IncludeModule('iblock');
			$this->cbe = new CIBlockElement;

			$this->getElemFromBlock($this->iblock_id);

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
		$arFilter = ["IBLOCK_ID"=> 2, "DATA_ACTIVE_FROM" => "ASC"];
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
		if(!$this->arCusResult){
			$this->addToBlock($this->result,$this->iblock_id);
		}else{
			if(isset($_SESSION['date_change']) && $_SESSION['date_change'] == $this->filemt){

			}else{
				$this->update($this->arCusResult,$this->result,$this->iblock_id);
			}

		}

		$_SESSION['date_change']=$this->filemt;


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

	public function update($old,$new,$iblock_id){
		$old_data = $old;
		$new_data = $new;
		foreach($old_data as $key1 => $value1) {

			foreach($new_data as $key2 => $value2){

				if($value1['id'] == $value2['id']){

					if(array_diff($value1,$value2)){

						foreach($value2 as $key => $val){

							$this->PROP[strtoupper($key)] = $val;
						}
						debug($this->PROP);
						$fields = [
							"NAME" =>$value2["name"],
							"PROPERTY_VALUES" => $this->PROP,
							"ACTIVE" => "Y"
						];
						$this->cbe->Update($key1,$fields);

					}
					unset($new_data[$key2]);//Удаляем запись из массива для дальнейшего добавления отсутствующих записей в БД
					break;
				}else{

					CIBlockElement::Delete($key1);// если товар отсутствует в файле - удаляем целиком запись из БД


				}
			}
		}
		$this->addToBlock($new_data,$iblock_id);

	}
}
