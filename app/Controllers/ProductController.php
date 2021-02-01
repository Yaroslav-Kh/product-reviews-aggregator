<?php


namespace App\Controllers;

use App\Models\ProductModel;
use Engine\Core\Controller;
use Engine\Libraries\Flash;
use Engine\Libraries\UrlManager;

class ProductController extends Controller
{
	private $errors;
	protected $model;

	public function __construct()
    {
        parent::__construct();

        $this->model = new ProductModel();

    }

    public function index() {

		$order = (isset($this->request->get('get')['order'])) ? $this->request->get('get')['order'] : null;
		$sort = (isset($this->request->get('get')['sort'])) ? $this->request->get('get')['sort'] : null;

        $results = $this->model->list($order, $sort);

        $data['products'] = [];

        foreach ($results as $result) {

            $data['products'][] = [
                'name'          => $result->name,
                'href'          => UrlManager::makeUrl('show/'.$result->id),
                'image'         => image('product/'.translit($result->name).'/small_'.$result->image),
                'date_added'    => $result->date_added,
                'author'        => $result->author,
                'review'        => $result->review
            ];

        }

        $data['product_added'] = Flash::get('product_added');

        $data['add'] = UrlManager::makeUrl('add');

        $data['order'] = $order;
        $data['sort'] = $sort;

        return $this->view->render('product/list', $data);
    }

	public function add() {

        $data['error_name'] = Flash::get('error_name');
        $data['error_image'] = Flash::get('error_image');
        $data['error_price'] = Flash::get('error_price');
        $data['error_author'] = Flash::get('error_author');
        $data['product_exist'] = Flash::get('product_exist');

        $data['back'] = UrlManager::makeUrl();
        $data['action'] = UrlManager::makeUrl('store');

		return $this->view->render('product/add',  $data);

	}

	public function store() {

		if (!$this->validate()) {

			return back();
		}

		$result = $this->model->add($this->request->get('post'));
		if ($result) {
            Flash::set('product_added', 'Товар успешно добавлен!');
		    return redirect('/');
        } else {
            Flash::set('product_exist', 'Невозможно добавить товар!');
            return back();
        }

    }

	public function show($id) {

	    $results = $this->model->show($id);

	    $data['product'] = [
	        'id'        => $results['product']->id,
	        'name'      => $results['product']->name,
            'image'     => image('product/'.translit($results['product']->name).'/large_'.$results['product']->image),
            'rating'    => ceil($results['product']->rating)

        ];

	    foreach ($results['reviews'] as $review) {

            $data['reviews'][] = [
                'username'      => $review->username,
                'rating'        => $review->rating,
                'comment'       => $review->comment,
                'date_added'    => $review->date_added,

            ];
        }
	    
        $data['back'] = UrlManager::makeUrl();

        return $this->view->render('product/show',  $data);


	}

	private function validate() {

		if ((strlen($this->request->get('post')['name']) < 1 )) {
		    $this->errors['error_name'] = true;
            Flash::set('error_name', 'Обязательно к заполнению!');
		}

		if ((strlen($this->request->get('post')['image']) < 1)) {
            $this->errors['error_image'] = true;
            Flash::set('error_image', 'Обязательно к заполнению!');
		}
		if (!is_image($this->request->get('post')['image'])) {
            $this->errors['error_image'] = true;
            Flash::set('error_image', 'Не верный формат ссылки!');
		}

		if ((strlen($this->request->get('post')['price']) < 1)) {
            $this->errors['error_price'] = true;
            Flash::set('error_price', 'Обязательно к заполнению!');
		}

		if ((strlen($this->request->get('post')['author']) < 1)) {
            $this->errors['error_author'] = true;
            Flash::set('error_author', 'Обязательно к заполнению!');
		}

		return !$this->errors;

	}

}