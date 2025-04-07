<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class AnyTableExport implements FromCollection, WithStrictNullComparison {
	public function __construct(public $tableClassName) {
	}

	/**
	 * @return \Illuminate\Support\Collection
	 */
	public function collection() {
		return $this->tableClassName::all();
	}
}
