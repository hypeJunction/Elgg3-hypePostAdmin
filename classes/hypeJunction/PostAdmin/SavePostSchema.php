<?php

namespace hypeJunction\PostAdmin;

use Elgg\BadRequestException;
use Elgg\Request;
use Http\Client\Curl\ResponseBuilder;

class SavePostSchema {

	/**
	 * Save menu
	 *
	 * @param Request $request Request
	 *
	 * @return ResponseBuilder
	 */
	public function __invoke(Request $request) {

		$name = $request->getParam('name');
		$sections = $request->getParam('sections');

		if (!$name || !$sections) {
			throw new BadRequestException();
		}

		$sections = json_decode($sections, true);
		elgg_save_config("form:$name", $sections);

		$msg = elgg_echo('post:admin:save:success');

		return elgg_ok_response('', $msg);
	}
}