<?php

class Application_Form_Thread extends Zend_Form
{

    public function init()
    {
        $this->setMethod("post");

        $title = new Zend_Form_Element_Text("title");
        $title->setLabel("Title : ");
        $title->setRequired();
        $title->setAttrib("class", "form-control");
        $title->addFilter(new Zend_Filter_StripTags);

        $body = new Zend_Form_Element_Textarea("body");
        $body->setLabel("Body : ");
        $body->setRequired();
        $body->setAttrib('cols', '40');
        $body->setAttrib('rows', '10');
        $body->setAttrib("class", "form-control");
        $body->addFilter(new Zend_Filter_StripTags);

        $image = new Zend_Form_Element_File("image");
        $image->addValidator(new Zend_Validate_File_Size(2048 * 1024));
        $image->addValidator(new Zend_Validate_File_IsImage());
        $image->setValueDisabled(true);
        $image->addValidator('Count', false, 1);
        $image->setLabel("Choose Image");



        $fors=new Application_Model_Forums();
         $allFor=$fors->listForum();
         $names[""]="Select Forum";
         foreach ($allFor as $key => $value) 
         {
             $names[$value['id']] =  $value["name"];
         }
               
         $forum_id=new Zend_Form_Element_Select("forum_id");
         $forum_id->setAttrib("name", "forum_id");
         $forum_id->setLabel('Forum ');
         $forum_id->setAttrib("class", "form-control");
         $forum_id->setMultiOptions($names);


        $uses=new Application_Model_Users();
         $allUse=$uses->listUsers();
         $names[""]="Select User";
         foreach ($allUse as $key => $value) 
         {
             $names[$value['id']] =  $value["name"];
         }
               
         $user_id=new Zend_Form_Element_Select("user_id");
         $user_id->setAttrib("name", "user_id");
         $user_id->setLabel('User ');
         $user_id->setAttrib("class", "form-control");
         $user_id->setMultiOptions($names);




        $id = new Zend_Form_Element_Hidden("id");
        $submit = new Zend_Form_Element_Submit("submit");
        $submit->setLabel("Post");
        $submit->setAttrib("class", "btn btn-primary");
        $this->addElements(array($id, $title, $body, $image,$forum_id ,$user_id ,$submit));
    }


}

