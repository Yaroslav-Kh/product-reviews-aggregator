<?php


namespace Engine\Core;


class View
{


    public function render($template, $data = []) {

        extract($data, EXTR_OVERWRITE);

		$loader = new \Twig\Loader\FilesystemLoader(TEMPLATES);

		$twig = new \Twig\Environment($loader, [
			'cache' => false,
		]);

		return $twig->render($template.'.html.twig', $data);

    }

}