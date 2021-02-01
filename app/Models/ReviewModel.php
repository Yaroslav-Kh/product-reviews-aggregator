<?php


namespace App\Models;


use Engine\Core\DB;

class ReviewModel extends DB
{

	public function add($data) {

		try {

			$stmt = $this->db->prepare("SELECT COUNT(id) as count FROM reviews WHERE username = :username");
			$stmt->execute([
				':username' => $data['username'],
			]);

			if ($stmt->fetch()->count) {
				return ['exist' => true];
			}

			$stmt = $this->db->prepare("INSERT INTO reviews ( product_id, username, rating, comment) VALUES (:product_id, :username, :rating, :comment)");

			$stmt->execute([
				':product_id' 	=> $data['product_id'],
				':username' 	=> $data['username'],
				':rating' 		=> $data['rating'],
				':comment' 		=> htmlspecialchars($data['comment']),
			]);

			$stmt = $this->db->prepare("SELECT AVG(rating) as rating  FROM reviews  WHERE product_id = :id");
			$stmt->execute([
				':id' => $data['product_id'],
			]);

			return [
				'success' 	=> true,
				'rating'	=> ceil($stmt->fetch()->rating),
				'review'	=> [
					'username' 		=> htmlspecialchars($data['username']),
					'rating' 		=> ceil($data['rating']),
					'comment' 		=> htmlspecialchars($data['comment']),
				]
			];

		} catch (\Exception $e) {

			return ['error' => true];

		}

	}

}