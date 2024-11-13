
<?php


$example_persons_array = [
    [
        'fullname' => 'Иванов Иван Иванович',
        'job' => 'tester',
    ],
    [
        'fullname' => 'Степанова Наталья Степановна',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Пащенко Владимир Александрович',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Громов Александр Иванович',
        'job' => 'fullstack-developer',
    ],
    [
        'fullname' => 'Славин Семён Сергеевич',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Цой Владимир Антонович',
        'job' => 'frontend-developer',
    ],
    [
        'fullname' => 'Быстрая Юлия Сергеевна',
        'job' => 'PR-manager',
    ],
    [
        'fullname' => 'Шматко Антонина Сергеевна',
        'job' => 'HR-manager',
    ],
    [
        'fullname' => 'аль-Хорезми Мухаммад ибн-Муса',
        'job' => 'analyst',
    ],
    [
        'fullname' => 'Бардо Жаклин Фёдоровна',
        'job' => 'android-developer',
    ],
    [
        'fullname' => 'Шварцнегер Арнольд Густавович',
        'job' => 'babysitter',
    ],
];
 
/*************etFullnameFromParts********************************/

function getFullnameFromParts ($surname, $name, $patronomyc){
  return  $surname . ' ' . $name . ' ' . $patronomyc;
};
/*_____________________________________________________________*/



/****************getPartsFromFullname************************/

function getPartsFromFullname ($str){
 $values = explode(" ", $str);
 $key  = ['surname','name','patronomyc'];
  $arrayCombin = array_combine($key,$values);
 return $arrayCombin;
};
/*_____________________________________________________________*/



/******************getShortName****************************/
function getShortName($str){
  $arrstr = getPartsFromFullname($str);
  $firstLetter = mb_substr($arrstr['surname'], 0, 1);
  return  $arrstr['name'].' '.$firstLetter.'.';
};
/*______________________________________________________*/




/****************getGenderFromName***********************/

function getGenderFromName($str){
$arrsurname = getPartsFromFullname($str);
$surname = mb_substr($arrsurname['surname'], -1 ,1);
$name= mb_substr($arrsurname['name'], -1 ,1);
$patronomyc= mb_substr($arrsurname['patronomyc'], -2 ,2);
$gender= 0;

if ($surname ==="в"){
    $gender = $gender+1;
}
elseif( $surname ==="а" ){
    $gender = $gender-1;
}

if ($name ==="й" ||$name ==="н"){
    $gender = $gender+1;
}
elseif( $surname ==="а" ){
    $gender = $gender-1;
}

if ($patronomyc ==="ич" ){
    $gender = $gender+1;
}
elseif( $patronomyc ==="на" ){
    $gender = $gender-1;
};

switch ($gender <=> 0) {
    case 0:
        $getGende = "Пол не определен";
        break;
    case 1:
        $getGende = "Мужской пол";
        break;
    case -1:
         $getGende ="Женский пол";
        break;
}

return $getGende;

};
/*___________________________________________________________________ */


/************************getGenderDescription*********************** */
function getGenderDescription($array){
$length = count($array);
$newArray =[];

for ($i = 0; $i< $length; $i++){
    $newArray[] = $array[$i]['fullname'];
  };
 $numberNewArray = count($newArray);
 $man = 0;
 $woman = 0;
 $notDefined = 0;
 for ($i = 0; $i< $numberNewArray; $i++){
 $genders = getGenderFromName($newArray[$i]);
 if ($genders ==="Женский пол"){
    $woman = $woman + 1;
   }
    elseif ($genders ==="Мужской пол"){
        $man = $man +1;
   }
   elseif ($genders ==="Пол не определен"){
    $notDefined =$notDefined +1;
}

  };


  $percentMan = round(($man*100)/$numberNewArray,1);
  $percentWoman = round(($woman*100)/$numberNewArray,1);
  $percentNotDefined = round(($notDefined*100)/$numberNewArray,1);

  $result = <<<EOD
  Гендерный состав аудитории:
  ---------------------------
  Мужчины - $percentMan %
  Женщины - $percentWoman %
  Не удалось определить - $percentNotDefined %
EOD;

return  $result;
};
/*_______________________________________________________________________*/



/***************************getPerfectPartner*************************** */
function getPerfectPartner ($surname, $name, $patronomyc, $array){
$surname2= mb_strtolower($surname);
$name2 =mb_strtolower($name);
$patronomyc2 = mb_strtolower($patronomyc);
$fulname = getFullnameFromParts ($surname2, $name2, $patronomyc2);
$fulname2= mb_convert_case($fulname, MB_CASE_TITLE, "UTF-8");
$nameSurname = getShortName ($fulname2);
$genderUsed =  getGenderFromName($fulname);
$arreyLength = count($array);
$newArray =[];
for ($i = 0; $i< $arreyLength; $i++){
    $newArray[] = $array[$i]['fullname'];
  };

$randomUser = $newArray [rand(0, $arreyLength-1)];
$genderRandomUser =  getGenderFromName($randomUser);

while ($genderRandomUser === $genderUsed || $genderRandomUser ==="Пол не определен" ){

    $randomUser = $newArray [rand(0, $arreyLength-1)];
    $genderRandomUser =  getGenderFromName($randomUser);
 }

 $randomUser = getShortName ($randomUser);
$randomNamder = rand(0, 95);
$percent =  round(($randomNamder*100)/98,2);

$perfectСouple = <<<EOD
$nameSurname + $randomUser = 
♡ Идеально на $percent% ♡
EOD;

return  $perfectСouple;
};
/*________________________________________________________________________________*/



$fio = getFullnameFromParts ('Комисарова', 'Надежда', 'Ивановна');
echo $fio;
echo "\n";
$arrFio = getPartsFromFullname($fio);
echo "\n";
print_r($arrFio);
echo "\n";
$reduction = getShortName ($fio);
echo "\n";
echo $reduction;
$arrFio = getGenderFromName($fio);
echo "\n";
echo $arrFio;
echo "\n";
echo "\n";
$s = getGenderDescription($example_persons_array);
echo $s;
echo "\n";
echo "\n";
$Partner = getPerfectPartner ("ниКитин", "ЕвгеНий", "ИгоЕвичь",$example_persons_array);
echo $Partner;

