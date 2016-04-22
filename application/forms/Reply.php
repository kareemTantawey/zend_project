<?php

class Application_Form_Reply extends Zend_Form
{

    public function init()
    {
        /* Form Elements & Other Definitions Here ... */
        $this->setMethod("post");
        $this->setAttrib("class","form-horizontal");
        
        $reply = new Zend_Form_Element_Textarea("body");
        $reply->setAttrib('cols', '40');
        $reply->setAttrib('rows', '3');
        $reply->setRequired();
        $reply->addFilter(new Zend_Filter_StripTags);
        $reply->setAttrib("class", "form-control");
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Add Reply");
        $submit->setAttrib("class", "btn btn-primary");
        
        $this->addElements(array($reply, $submit));

        $id = new Zend_Form_Element_Hidden("id");
    }


}

