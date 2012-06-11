<?php

/**
 * My Application
 *
 * @copyright  Copyright (c) 2010 John Doe
 * @package    MyApplication
 */



/**
 * Users authenticator.
 *
 * @author     John Doe
 * @package    MyApplication
 */
class UserModel extends BaseModel implements IAuthenticator
{

    const OK = 1;
    const ERROR_DUPLICATION_EMAIL = -1;
    //const ERROR_DUPLICATION_IC = -2;
    const ERROR_UNKNOWN = -3;

    /**
     * Performs an authentication
     * @param  array
     * @return Identity
     * @throws AuthenticationException
     */
    public function authenticate(array $credentials) {
        list($email, $password) = $credentials;
        $user = self::$notORM->user[array('email' => $email)];

        if (!$user) {
            throw new AuthenticationException("Uživatel '$email' nebyl nalezen.", self::IDENTITY_NOT_FOUND);
        }

        $config = Environment::getConfig('security');
        $password = hash_hmac('sha256', $credentials[self::PASSWORD] . $user['salt'], $config->hmacKey);

        if ($user['password'] !== $password) {
            throw new AuthenticationException("Špatné heslo.", self::INVALID_CREDENTIAL);
        }

        unset($user['password']);
        unset($user['salt']);

        return new Identity($user['id'], NULL, $user);
    }

    public static function register($values) {
        $values['salt'] = self::randChars('8');
        $config = Environment::getConfig('security');
        $password = $values['password'];

        $values['password'] = hash_hmac('sha256', $values['password'] . $values['salt'] , $config->hmacKey);

        $datetime = new DateTime53();
        $values['registered'] = $datetime;

        try {
            self::$notORM->user()->insert($values);
        }
        catch (PDOException $exc){
            if($exc->errorInfo[1] == 1062) {
                if (strpos($exc->getMessage(), $values['email'])) {
                    return self::ERROR_DUPLICATION_EMAIL;
                }
            }
            Debug::log($exc->getMessage());
            return self::ERROR_UNKNOWN;
        }

        return self::OK;
    }
    
    

    private static function randChars($length) {

        $chars = 'abcdefghijklmnopqrstuvwxyz123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        $countChars = strlen($chars);

        for ($i = 0; $i < $length; $i++) {
            $string .= substr($chars, mt_rand(0, $countChars), 1); //$znaky[mt_rand(0,$pocetZnaku)];
        }

        return $string;
    }

}
