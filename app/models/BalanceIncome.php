<?php

class BalanceIncome extends \Phalcon\Mvc\Model
{

    /**
     *
     * @var integer
     * @Primary
     * @Identity
     * @Column(type="integer", length=10, nullable=false)
     */
    public $income_id;

    /**
     *
     * @var integer
     * @Column(type="integer", length=10, nullable=false)
     */
    public $member_id;

    /**
     *
     * @var double
     * @Column(type="double", length=10, nullable=false)
     */
    public $change_balance;

    /**
     *
     * @var double
     * @Column(type="double", length=10, nullable=false)
     */
    public $before_balance;

    /**
     *
     * @var double
     * @Column(type="double", length=10, nullable=false)
     */
    public $after_balance;

    /**
     *
     * @var double
     * @Column(type="double", length=10, nullable=false)
     */
    public $left_balance;

    /**
     * Initialize method for model.
     */
    public function initialize()
    {
        $this->setSchema("phalcon");
        $this->belongsTo('member_id', '\BalanceMember', 'member_id', ['alias' => 'BalanceMember']);
    }

    /**
     * Returns table name mapped in the model.
     *
     * @return string
     */
    public function getSource()
    {
        return 'balance_income';
    }

    /**
     * Allows to query a set of records that match the specified conditions
     *
     * @param mixed $parameters
     * @return BalanceIncome[]|BalanceIncome
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * Allows to query the first record that match the specified conditions
     *
     * @param mixed $parameters
     * @return BalanceIncome
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

}
