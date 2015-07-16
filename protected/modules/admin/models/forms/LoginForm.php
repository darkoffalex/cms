<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class LoginForm extends CFormModel
{
	public $username;
	public $password;
	private $_identity;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
        return array(
            // username and password are required
            array('username, password', 'required'),
            // password needs to be authenticated
            array('password', 'authenticate'),
        );
	}


    public function attributeLabels()
    {
        return array(
            'username' => __a('Login'),
            'password' => __a('Password')
        );
    }


	/**
	 * Authenticates the password.
	 * This is the 'authenticate' validator as declared in rules().
	 */
    public function authenticate($attribute,$params)
    {
        if(!$this->hasErrors())
        {
            $this->_identity=new AdminIdentity($this->username,$this->password);
            if(!$this->_identity->authenticate())
            {
                if($this->_identity->errorCode == UserIdentity::ERROR_PASSWORD_INVALID)
                {
                    $this->addError('password',__a('Incorrect password'));
                }
                elseif($this->_identity->errorCode == UserIdentity::ERROR_USERNAME_INVALID)
                {
                    $this->addError('username',__a('User not found in database'));
                }
                elseif($this->_identity->errorCode == UserIdentity::ERROR_UNKNOWN_IDENTITY)
                {
                    $this->addError('username',__a('Unknown error. Authentication failed'));
                }
            }
        }
    }

	/**
	 * Logs in the user using the given username and password in the model.
	 * @return boolean whether login is successful
	 */
	public function login()
	{
		if($this->_identity===null)
		{
			$this->_identity=new AdminIdentity($this->username,$this->password);
			$this->_identity->authenticate();
		}
		if($this->_identity->errorCode===AdminIdentity::ERROR_NONE)
		{
            //login (start user's session)
            $logged = Yii::app()->user->login($this->_identity);

            //get IPs
            $ip = findUserIP();
            $ipBehindProxy = findUserIP(true);

            //get related to DB user object
            $userDBObj = CurUser::get()->userObj();

            //set last visit time, last visit IP, and add new IPs to list
            $userDBObj -> last_visit_time = time();
            $userDBObj -> last_ip = $ipBehindProxy;
            $userDBObj -> addVisitIp($ip);
            $userDBObj -> addVisitIp($ipBehindProxy);
            $updated = $userDBObj -> update();

            //if updating failed - logout user
            if(!$updated && $logged){
                Yii::app()->getUser()->logout(false);
                $logged = false;
            }

			return $logged;
		}
		else
        {
            return false;
        }
	}
}
