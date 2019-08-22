<?php
/** 
*
*/
namespace App\Tools;
/**
*
*/
use Medoo\Medoo as Medoo;
use Medoo\Raw as Raw;


/**SINGLETON CLASS (CHECK DATABASE POOL FOR MULTITON DATABASES)
 * 
 */
class Database extends Medoo{

    //singleton instance property
    protected static $instance;

    /* SINGLETON CONTRUCTOR
     * 
     * options: ['databaseName'=>[medoo options]]
     */
    public static function instanciate(array $options){

        if (!self::$instance instanceof self){

            self::$instance = new self($options);
   
        }

       return self::$instance;

    }

    /* PASSWORD (OR ANY 2 FIELD VALIDATION)
     *
     *   table: the table where the field is
     *   fields: the name field and password keys
     *   register: the variables to validate
     */

    public function validate($table,$fields,$register){

        //register took from database
        $_register=$this->get($table,[$fields['identity'],$fields['password']],[$fields['identity']=>$register['identity']]);

        //if the register is not in the table then we return -1
        if(!isset($_register[$fields['identity']])){

            return -1;

        }
        //if the register exists we can return 0 or 1
        else{

            //if the password is correct we can validate it by returning 1
            if($register['password']===$_register['password']){

                return 1;

            }
            else{

                //if the password is incorrect we can return 0 
                return 0;

            }

        }

    }
    
}


?>