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
        /* @var $user UserEx */

        $user = UserEx::model()->findByAttributes(array('login' => $this->username));

        //if user found
        if(!empty($user))
        {
            $hashed_pass = md5($this->password);

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
                $this->setState('role_id', $user->role_id);
                $this->setState('role_name', $user->role->label);
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