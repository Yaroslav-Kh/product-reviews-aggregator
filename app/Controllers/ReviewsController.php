<?php


namespace App\Controllers;


use App\Models\ReviewModel;
use Engine\Core\Controller;
use Engine\Core\Response;

class ReviewsController extends Controller
{

	protected $model;

	public function __construct()
	{
		parent::__construct();

		$this->model = new ReviewModel();

	}

	public function add() {

		$json = $this->model->add($this->request->get('post'));

		if (isset($json['exist'])) {
			$json['message'] = 'Вы уже оставляли отзыв для этого товара';
		}

		if (isset($json['success'])) {
			$json['message'] = 'Отзыв успешно добавлен';
		}

		if (isset($json['error'])) {
			$json['message'] = 'Не удалось добавить отзыв. Обратитесь к администратору';
		}

		return Response::json($json);

	}

}