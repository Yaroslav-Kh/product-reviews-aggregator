<?php


namespace App\Models;


use Engine\Core\DB;
use Engine\Libraries\Flash;
use Intervention\Image\ImageManagerStatic as Image;

class ProductModel extends DB
{

    protected $small_width;
    protected $small_height;
    protected $large_width;
    protected $large_height;

    public function __construct()
    {
        parent::__construct();
        // SET IMAGE DRIVER
        // DEFAULT - GD
        Image::configure(array('driver' => 'gd'));

        // SET IMAGE RESIZE
        $imageConfig = loadFile('config','image');
        $this->small_width = $imageConfig['small']['width'];
        $this->small_height = $imageConfig['small']['height'];
        $this->large_width = $imageConfig['large']['width'];
        $this->large_height = $imageConfig['large']['height'];

    }

    public function list($order = null, $sort = null) {

        try {

            $sql = 'SELECT p.*, COUNT(r.id) as review FROM product p  LEFT JOIN reviews r ON (r.product_id = p.id) GROUP BY p.id';

            if (null !== $order && $sort) {


                if ($order == 'reviews') {
                    $order = 'COUNT(r.id) ';
                }

                $sql .= ' ORDER BY '. $order .' '.strtoupper($sort);

            } else {
                $sql .= ' ORDER BY p.date_added DESC';
            }



            $stmt = $this->db->query($sql);

            return $stmt->fetchAll();

        } catch (\Exception $e) {

            return false;
        }

    }

    public function add($data)
    {

        try {

            $stmt = $this->db->prepare("SELECT COUNT(id) as count FROM product WHERE name = :name");
            $stmt->execute([
                ':name' => $data['name'],
            ]);

            if ($stmt->fetch()->count) {
                return false;
            }

            $explode = explode('.',$data['image']);
            $mimeType = end($explode);

            $stmt = $this->db->prepare("INSERT INTO product ( name, image, price, author) VALUES (:name, :image, :price, :author)");

            $stmt->execute([
                ':name' => $data['name'],
                ':image' => translit($data['name']).'.'.$mimeType,
                ':price' => $data['price'],
                ':author' => $data['author'],
            ]);

            if (!file_exists(public_image('product/'.translit($data['name'])))) {
                mkdir(public_image('product/'.translit($data['name'])), 0777, true);
            }

            Image::make($data['image'])->resize($this->small_width, $this->small_height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_image('product/'.translit($data['name']).'/small_'.translit($data['name']).'.'.$mimeType));

            Image::make($data['image'])->resize($this->large_width, $this->large_height, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_image('product/'.translit($data['name']).'/large_'.translit($data['name']).'.'.$mimeType));

            return true;

        } catch (\Exception $e) {

            return false;
        }
    }

    public function show($id) {

        try {

            $stmt = $this->db->prepare("SELECT p.id, p.name, p.image, p.price, AVG(r.rating) as rating  FROM product p  LEFT JOIN reviews r ON (r.product_id = p.id)  WHERE p.id = :id AND r.product_id = :id ");
            $stmt->execute([
                ':id' => $id,
            ]);

            $product = $stmt->fetch();

            $stmt = $this->db->prepare("SELECT username, rating, comment, date_added FROM reviews WHERE product_id = :id");
            $stmt->execute([
                ':id' => $id,
            ]);

            $reviews = $stmt->fetchAll();

            return [
                'product' => $product,
                'reviews' => $reviews
            ];

        } catch (\Exception $e) {

            return  false;

        }

    }

}