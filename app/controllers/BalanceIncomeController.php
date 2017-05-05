<?php
 
use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class BalanceIncomeController extends ControllerBase
{
    /**
     * Index action
     */
    public function indexAction()
    {
        $this->persistent->parameters = null;
    }

    /**
     * Searches for balance_income
     */
    public function searchAction()
    {
        $numberPage = 1;
        if ($this->request->isPost()) {
            $query = Criteria::fromInput($this->di, 'BalanceIncome', $_POST);
            $this->persistent->parameters = $query->getParams();
        } else {
            $numberPage = $this->request->getQuery("page", "int");
        }

        $parameters = $this->persistent->parameters;
        if (!is_array($parameters)) {
            $parameters = [];
        }
        $parameters["order"] = "income_id";

        $balance_income = BalanceIncome::find($parameters);
        if (count($balance_income) == 0) {
            $this->flash->notice("The search did not find any balance_income");

            $this->dispatcher->forward([
                "controller" => "balance_income",
                "action" => "index"
            ]);

            return;
        }

        $paginator = new Paginator([
            'data' => $balance_income,
            'limit'=> 10,
            'page' => $numberPage
        ]);

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * Displays the creation form
     */
    public function newAction()
    {

    }

    /**
     * Edits a balance_income
     *
     * @param string $income_id
     */
    public function editAction($income_id)
    {
        if (!$this->request->isPost()) {

            $balance_income = BalanceIncome::findFirstByincome_id($income_id);
            if (!$balance_income) {
                $this->flash->error("balance_income was not found");

                $this->dispatcher->forward([
                    'controller' => "balance_income",
                    'action' => 'index'
                ]);

                return;
            }

            $this->view->income_id = $balance_income->income_id;

            $this->tag->setDefault("income_id", $balance_income->income_id);
            $this->tag->setDefault("member_id", $balance_income->member_id);
            $this->tag->setDefault("change_balance", $balance_income->change_balance);
            $this->tag->setDefault("before_balance", $balance_income->before_balance);
            $this->tag->setDefault("after_balance", $balance_income->after_balance);
            $this->tag->setDefault("left_balance", $balance_income->left_balance);
            
        }
    }

    /**
     * Creates a new balance_income
     */
    public function createAction()
    {
        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "balance_income",
                'action' => 'index'
            ]);

            return;
        }

        $balance_income = new BalanceIncome();
        $balance_income->member_id = $this->request->getPost("member_id");
        $balance_income->change_balance = $this->request->getPost("change_balance");
        $balance_income->before_balance = $this->request->getPost("before_balance");
        $balance_income->after_balance = $this->request->getPost("after_balance");
        $balance_income->left_balance = $this->request->getPost("left_balance");
        

        if (!$balance_income->save()) {
            foreach ($balance_income->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "balance_income",
                'action' => 'new'
            ]);

            return;
        }

        $this->flash->success("balance_income was created successfully");

        $this->dispatcher->forward([
            'controller' => "balance_income",
            'action' => 'index'
        ]);
    }

    /**
     * Saves a balance_income edited
     *
     */
    public function saveAction()
    {

        if (!$this->request->isPost()) {
            $this->dispatcher->forward([
                'controller' => "balance_income",
                'action' => 'index'
            ]);

            return;
        }

        $income_id = $this->request->getPost("income_id");
        $balance_income = BalanceIncome::findFirstByincome_id($income_id);

        if (!$balance_income) {
            $this->flash->error("balance_income does not exist " . $income_id);

            $this->dispatcher->forward([
                'controller' => "balance_income",
                'action' => 'index'
            ]);

            return;
        }

        $balance_income->member_id = $this->request->getPost("member_id");
        $balance_income->change_balance = $this->request->getPost("change_balance");
        $balance_income->before_balance = $this->request->getPost("before_balance");
        $balance_income->after_balance = $this->request->getPost("after_balance");
        $balance_income->left_balance = $this->request->getPost("left_balance");
        

        if (!$balance_income->save()) {

            foreach ($balance_income->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "balance_income",
                'action' => 'edit',
                'params' => [$balance_income->income_id]
            ]);

            return;
        }

        $this->flash->success("balance_income was updated successfully");

        $this->dispatcher->forward([
            'controller' => "balance_income",
            'action' => 'index'
        ]);
    }

    /**
     * Deletes a balance_income
     *
     * @param string $income_id
     */
    public function deleteAction($income_id)
    {
        $balance_income = BalanceIncome::findFirstByincome_id($income_id);
        if (!$balance_income) {
            $this->flash->error("balance_income was not found");

            $this->dispatcher->forward([
                'controller' => "balance_income",
                'action' => 'index'
            ]);

            return;
        }

        if (!$balance_income->delete()) {

            foreach ($balance_income->getMessages() as $message) {
                $this->flash->error($message);
            }

            $this->dispatcher->forward([
                'controller' => "balance_income",
                'action' => 'search'
            ]);

            return;
        }

        $this->flash->success("balance_income was deleted successfully");

        $this->dispatcher->forward([
            'controller' => "balance_income",
            'action' => "index"
        ]);
    }

}
