<?php

class UsersController extends ControllerAdmin
{

    /**
     * Entry
     */
    public function actionIndex(){
        $this->redirect(Yii::app()->createUrl('admin/users/list'));
    }


    /************************************************ U S E R S ********************************************************/

    /**
     * Search list
     * @param int $page
     * @param string $search
     */
    public function actionList($page = 1, $search = ''){

        //get all users
        $users = empty($search) ? UserEx::model()->findAll() : UserEx::model()->searchByString($search);

        //paginate items
        $perPage = Constants::PER_PAGE;
        $items = CPager::getInstance($users,$perPage,$page)->getPreparedArray();

        $this->render('users_list',array('items' => $items, 'search' => $search));
    }

    /**
     * Updating user
     * @param $id
     * @throws CHttpException
     */
    public function actionEdit($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //get user by ID
        $user = UserEx::model()->findByPk((int)$id);
        $roles = RoleEx::model()->listAllItemsForForms();
        $statuses = Constants::statusListForUsers();
        $clientTypes = Constants::shopCliTypes();

        if(empty($user) || $user->readonly || $user->role->permission_level < CurUser::get()->permissionLvl()){
            throw new CHttpException(404);
        }

        //try get post request
        $post = Yii::app()->request->getPost('UserEx',null);

        //if post not empty
        if(!empty($post)){

            //get old password
            $oldPassword = $user->password;
            $oldRoleId = $user->role_id;

            //set main attributes
            $user->attributes = $post;

            //validate
            if($user->validate()){

                //check permissions for changing role
                $newRole = RoleEx::model()->findByPk((int)$post['role_id']);
                if(!empty($newRole) && $newRole->permission_level > CurUser::get()->permissionLvl()){
                    $user->role_id = $newRole->id;
                }else{
                    $user->role_id = $oldRoleId;
                }

                //reassigning password
                $user->password = !empty($post['password']) ? md5($post['password']) : $oldPassword;
                $user->updated_time = time();

                //uploading avatar and photo
                $user->avatar = CUploadedFile::getInstance($user,'avatar');
                $user->photo = CUploadedFile::getInstance($user,'photo');
                if(!empty($user->avatar) && $user->avatar->size > 0){

                    //save file to directory with new random name
                    $uploadPath = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'avatars';
                    $randomName = uniqid().'.'.$user->avatar->extensionName;
                    $destinationName = $uploadPath.DS.$randomName;

                    //if image saved - set filename info
                    if($user->avatar->saveAs($destinationName)){
                        $user->avatar_filename = $randomName;
                    }
                }
                if(!empty($user->photo) && $user->photo->size > 0){

                    //save file to directory with new random name
                    $uploadPath = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'avatars';
                    $randomName = uniqid().'.'.$user->photo->extensionName;
                    $destinationName = $uploadPath.DS.$randomName;

                    //if image saved - set filename info
                    if($user->photo->saveAs($destinationName)){
                        $user->photo_filename = $randomName;
                    }
                }

                if($user->update()){
                    //success message
                    Yii::app()->user->setFlash('success',__a('Success: All data saved'));
                }else{
                    //error message
                    Yii::app()->user->setFlash('error',__a('Error : Unknown error'));
                }
            }else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }

        }

        $this->render('users_edit',array('model' => $user, 'roles' => $roles, 'statuses' => $statuses, 'cliTypes' => $clientTypes));
    }

    /**
     * Adding a new user
     */
    public function actionAdd()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //new user
        $user = new UserEx();
        $roles = RoleEx::model()->listAllItemsForForms();
        $statuses = Constants::statusListForUsers();
        $clientTypes = Constants::shopCliTypes();

        //try get post request
        $post = Yii::app()->request->getPost('UserEx',null);

        //if post not empty
        if(!empty($post)){

            //set main attributes
            $user->attributes = $post;

            //validate
            if($user->validate()){

                $user->password = md5($post['password']);
                $user->created_time = time();
                $user->updated_time = time();

                //uploading avatar and photo
                $user->avatar = CUploadedFile::getInstance($user,'avatar');
                $user->photo = CUploadedFile::getInstance($user,'photo');
                if(!empty($user->avatar) && $user->avatar->size > 0){

                    //save file to directory with new random name
                    $uploadPath = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'avatars';
                    $randomName = uniqid().'.'.$user->avatar->extensionName;
                    $destinationName = $uploadPath.DS.$randomName;

                    //if image saved - set filename info
                    if($user->avatar->saveAs($destinationName)){
                        $user->avatar_filename = $randomName;
                    }
                }
                if(!empty($user->photo) && $user->photo->size > 0){

                    //save file to directory with new random name
                    $uploadPath = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'avatars';
                    $randomName = uniqid().'.'.$user->photo->extensionName;
                    $destinationName = $uploadPath.DS.$randomName;

                    //if image saved - set filename info
                    if($user->photo->saveAs($destinationName)){
                        $user->photo_filename = $randomName;
                    }
                }

                if($user->save()){
                    //success message
                    Yii::app()->user->setFlash('success',__a('Success: All data saved'));
                }else{
                    //error message
                    Yii::app()->user->setFlash('error',__a('Error : Unknown error'));
                }

                //back to list
                $this->redirect(Yii::app()->createUrl('admin/users/list'));

            }else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }

        }

        $this->render('users_edit',array('model' => $user, 'roles' => $roles, 'statuses' => $statuses, 'cliTypes' => $clientTypes));
    }

    /**
     * Delete by PK
     * @param $id
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        //get user by ID
        $user = UserEx::model()->findByPk((int)$id);

        if(empty($user) || $user->readonly || $user->role->permission_level <= CurUser::get()->permissionLvl() || $user->id == Yii::app()->getUser()->id){
            throw new CHttpException(404);
        }

        $user->delete();

        //back to list
        $this->redirect(Yii::app()->createUrl('admin/users/list'));
    }

    /**
     * Delete photo and back
     * @param $id
     * @throws CHttpException
     */
    public function actionDelPhoto($id)
    {
        //get user by ID
        $user = UserEx::model()->findByPk((int)$id);

        if(empty($user) || $user->readonly || $user->role->permission_level <= CurUser::get()->permissionLvl()){
            throw new CHttpException(404);
        }

        $file_path = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'avatars'.DS.$user->photo_filename;

        try{
            unlink($file_path);
            $user->photo_filename = null;
            $user->update();
        }catch (Exception $ex){
            exit($ex->getMessage());
        }

        $this->redirect(Yii::app()->getRequest()->urlReferrer);
    }

    /**
     * Delete avatar and back
     * @param $id
     * @throws CHttpException
     */
    public function actionDelAvatar($id)
    {
        //get user by ID
        $user = UserEx::model()->findByPk((int)$id);

        if(empty($user) || $user->readonly || $user->role->permission_level <= CurUser::get()->permissionLvl()){
            throw new CHttpException(404);
        }

        $file_path = YiiBase::getPathOfAlias("webroot").DS.'uploads'.DS.'avatars'.DS.$user->avatar_filename;

        try{
            unlink($file_path);
            $user->avatar_filename = null;
            $user->update();
        }catch (Exception $ex){
            exit($ex->getMessage());
        }

        $this->redirect(Yii::app()->getRequest()->urlReferrer);
    }

    /************************************************ R O L E S ********************************************************/

    /**
     * List all roles
     */
    public function actionRoles()
    {
        $roles = RoleEx::model()->findAll(array('order' => 'permission_level ASC'));
        $this->render('roles_list',array('items' => $roles));
    }

    /**
     * Editing role
     * @param $id
     * @throws CHttpException
     */
    public function actionEditRole($id)
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //get role and languages
        $role = RoleEx::model()->findByPk((int)$id);
        $languages = Language::model()->findAll();

        //if role not found or if have no permission
        if(empty($role) || $role->permission_level < CurUser::get()->permissionLvl()){
            throw new CHttpException(404);
        }

        //try get post
        $post = Yii::app()->request->getPost('RoleEx',null);

        //if post got
        if(!empty($post)){

            //translatable data
            $names = !empty($post['name']) ? $post['name'] : array();
            $descriptions = !empty($post['description']) ? $post['description'] : array();

            //permission array
            $permissions = !empty($post['permissions']) ? $post['permissions'] : array();
            $permissionsStr = serialize($permissions);

            //store old parameters
            $oldLabel = $role->label;
            $oldAdminAccess = $role->admin_access;
            $oldPermissions = $role->permissions;

            //set main attributes and permissions
            $role->attributes = $post;
            $role->permissions = $permissionsStr;

            if($role->validate()){

                //open transaction
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();

                try{
                    //if we trying modify our role
                    if($role->id == CurUser::get()->roleId()){

                        //restore old parameters
                        $role->label = $oldLabel;
                        $role->admin_access = $oldAdminAccess;
                        $role->permissions = $oldPermissions;
                    }

                    //update
                    $role->updated_time = time();
                    $role->updated_by_id = Yii::app()->getUser()->id;
                    $role->update();

                    //save translatable data
                    foreach($languages as $lng)
                    {
                        $name = !empty($names[$lng->id]) ? $names[$lng->id] : '';
                        $description = !empty($descriptions[$lng->id]) ? $descriptions[$lng->id] : '';

                        $trl = $role->getOrCreateTrl($lng->id);
                        $trl->name = $name;
                        $trl->description = $description;
                        $ok = $trl->isNewRecord ? $trl->save() : $trl->update();
                    }

                    $transaction->commit();

                    //success message
                    Yii::app()->user->setFlash('success',__a('Success: All data saved'));
                }
                catch(Exception $ex){
                    //discard changes
                    $transaction->rollback();
                    //exit script and show error message
                    exit($ex->getMessage());
                }
            }else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }


        }

        //render form
        $this->render('roles_edit',array('model' => $role, 'languages' => $languages));
    }

    /**
     * Adding new role
     */
    public function actionAddRole()
    {
        //register all necessary styles
        Yii::app()->clientScript->registerCssFile($this->assets.'/css/vendor.add-menu.css');
        //register all necessary scripts
        Yii::app()->clientScript->registerScriptFile($this->assets.'/js/vendor.add-menu.js',CClientScript::POS_END);

        //new role
        $role = new RoleEx();
        $languages = Language::model()->findAll();

        //try get post
        $post = Yii::app()->request->getPost('RoleEx',null);

        //translatable data
        $names = !empty($post['name']) ? $post['name'] : array();
        $descriptions = !empty($post['description']) ? $post['description'] : array();

        //permission array
        $permissions = !empty($post['permissions']) ? $post['permissions'] : array();
        $permissionsStr = serialize($permissions);

        //if post got
        if(!empty($post)){

            //set main attributes
            $role->attributes = $post;
            //set permissions
            $role->permissions = $permissionsStr;

            if($role->validate()){

                //open transaction
                $connection = Yii::app()->db;
                $transaction = $connection->beginTransaction();

                try{
                    //save new item
                    $role->created_time = time();
                    $role->created_by_id = Yii::app()->getUser()->id;
                    $role->updated_time = time();
                    $role->updated_by_id = Yii::app()->getUser()->id;
                    $role->permission_level = Sort::GetNextPriority('RoleEx',array(),'permission_level');
                    $role->save();

                    //save translatable data
                    foreach($languages as $lng)
                    {
                        $name = !empty($names[$lng->id]) ? $names[$lng->id] : '';
                        $description = !empty($descriptions[$lng->id]) ? $descriptions[$lng->id] : '';

                        $trl = $role->getOrCreateTrl($lng->id);
                        $trl->name = $name;
                        $trl->description = $description;
                        $ok = $trl->isNewRecord ? $trl->save() : $trl->update();
                    }

                    $transaction->commit();

                    //success message
                    Yii::app()->user->setFlash('success',__a('Success: All data saved'));

                    //back to list
                    $this->redirect(Yii::app()->createUrl('admin/users/roles'));
                }
                catch(Exception $ex){
                    //discard changes
                    $transaction->rollback();
                    //exit script and show error message
                    exit($ex->getMessage());
                }
            }else{
                //error message
                Yii::app()->user->setFlash('error',__a('Error : Some of fields not valid'));
            }

        }

        //render form
        $this->render('roles_edit',array('model' => $role, 'languages' => $languages));
    }

    /**
     * Deleting role
     * @param $id
     * @throws CHttpException
     */
    public function actionDeleteRole($id)
    {
        //finding role
        $role = RoleEx::model()->findByPk((int)$id);
        //if role not found or if have no permission
        if(empty($role) || $role->permission_level <= CurUser::get()->permissionLvl()){
            throw new CHttpException(404);
        }
        //delete
        $role->delete();
        //back to list
        $this->redirect(Yii::app()->createUrl('admin/users/roles'));
    }

}