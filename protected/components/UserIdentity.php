<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{
        /* @var $user UsersEx */

        $user = UsersEx::model()->findByAttributes(array('login' => $this->username));

        //if user found
        if(!empty($user))
        {
            $salt = $user->salt;
            $hashed_pass = md5($this->password.$salt);

            //if password not correct
            if($user->password !== $hashed_pass)
            {
                //can't connect
                $this->errorCode = self::ERROR_PASSWORD_INVALID;
            }
            //if no errors
            else
            {
                //no error
                $this->errorCode = self::ERROR_NONE;

                //write params to session
                $this->setState('id',$user->id);
                $this->setState('login',$user->login);
                $this->setState('name',$user->info->name);
                $this->setState('last_name',$user->info->last_name);
                $this->setState('nick_name',$user->info->nick_name);
                $this->setState('group_id',$user->group_id);
                $this->setState('group_name',$user->group->name);
                $this->setState('language_id',$user->info->preferred_langauge_id);
                $this->setState('country_id',$user->info->preferred_country_id);
                $this->setState('city_id',$user->info->preferred_city_id);
            }
        }
        //if user not found
        else
        {
            //can't connect
            $this->errorCode = self::ERROR_USERNAME_INVALID;
        }

        //return error status
		return !$this->errorCode;
	}
}