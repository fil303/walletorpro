<?php

namespace App\Services\TableActionGeneratorService;


/**
 * Class GeneratorService
 * 
 * @method GeneratorService render()
 */
class GeneratorService
{
    private string $activeKey;

    /**
     * Active Array Set
     * var array<string, array<string, array<string, array<string>>>>
     * @var array<mixed>
     */
    private array $activeArraySet = [];

    public function setNode(string $key, string $title = "", string $icon = null):GeneratorService
    {
        $this->activeKey = $key;
        $this->setArraySet('title', $title);
        $icon && $this->setArraySet('icon', $icon);
        return $this;
    }

    private function setArraySet(string $key, string $value):GeneratorService
    {
        if($this->checkArraySet()) $this->setEmptyArraySet();
        if(
            !empty($hasMultikeys = $this->hasMultiDimensionsKey($key)) &&
            $hasMultikeys['status']
        ){
            return $this->setMultiArraySet( $hasMultikeys['keys'], $value);
        }
        $this->activeArraySet[$this->activeKey][$key] = $value;
        return $this;
    }

    /**
     * Set Multi Array Set
     * @param array<int, string> $keys
     * @param string $value
     * @return \App\Services\TableActionGeneratorService\GeneratorService
     */
    private function setMultiArraySet(array $keys, string $value): GeneratorService
    {
        $indexNumber = count($keys);
        if($indexNumber > 0){
            if($indexNumber == 1)
                $this->activeArraySet[$keys[0]] = $value;
            if($indexNumber == 2)
                $this->activeArraySet[$keys[0]][$keys[1]] = $value;
            if($indexNumber == 3)
                $this->activeArraySet[$keys[0]][$keys[1]][$keys[2]] = $value;
            if($indexNumber == 4)
                $this->activeArraySet[$keys[0]][$keys[1]][$keys[2]][$keys[3]] = $value;
        }else dd("indexNumber is invalid");
        return $this;
    }

    private function hasMultiDimensionsKey(string $key) : array
    {
        $expression = (strpos($key, ".") !== false);
        return [
            "status" => $expression,
            "keys"   => explode(".", $key)
        ];
    }

    private function setEmptyArraySet() : void
    {
        $this->activeArraySet = [];
    }
    private function checkArraySet() : bool
    {
        return $this->activeArraySet == null;
    }

    public function attr(string $keys, string $value):GeneratorService
    {
        if($this->checkArraySet()) return $this;
        $keys = $this->activeKey.'.attributs.'.$keys;
        return $this->setArraySet($keys, $value);
    }

    public function button(bool $subClass = true):string
    {
        if($subClass) $this->render()->renderTableOption($this->activeArraySet);
        return $this->renderTableOption($this->activeArraySet);
    }

    public function option(bool $subClass = true):string
    {
        if($subClass) $this->render()->renderTableOption($this->activeArraySet);
        return $this->renderTableOption($this->activeArraySet,true);
    }

    /**
     * Render Table Option
     * @param array<string, array<string, mixed>> $optionSet
     * @param bool $option
     * @return string
     */
    public function renderTableOption(array $optionSet, bool $option = false):string
    {
        $buttons = '<div class="flex justify-center">';
        $options = '
        <div class="dropdown dropdown-left dropdown-end">
            <div tabindex="0" role="button" class="btn btn-info btn-xs m-1">'._t("Action").'</div>
            <ul tabindex="0" class="dropdown-content menu bg-[#fff] p-2 shadow rounded-box w-52">
        ';
        foreach($optionSet as $key => $newSet){
                $title = isset($newSet['title']) ? $newSet['title'] : "";
                $icon  = isset($newSet['icon'])  ? $newSet['icon']  : "";
                $attribut = '';
                if( isset($newSet['attributs']) ){
                    foreach($newSet['attributs'] as $attr => $value)
                        $attribut .= $attr .'="'.$value.'" ';
                }
                if(!$option){
                    $buttons .= '<a type="button" ';
                    $buttons .= $attribut. " >";
                    $buttons .= $icon . $title . "</a>";
                }else{
                    $options .= '<li><a type="button" '. $attribut ." >";
                    $options .= $icon . $title . "</a></li>";
                }
        }
        if($option) return $options.'</ul></div>';
        return $buttons.'</div>';
    }
}