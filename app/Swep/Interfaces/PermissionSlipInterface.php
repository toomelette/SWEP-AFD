<?php

namespace App\Swep\Interfaces;
 


interface PermissionSlipInterface {

	public function fetch($request);

	public function store($request);

	public function update($request, $slug);

	public function destroy($slug);

	public function findBySlug($slug);
		
}