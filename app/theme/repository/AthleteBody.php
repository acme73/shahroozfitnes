<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;
use App\utils\NumberConvert;
use App\utils\PersianDate;
use DateTime;

defined('ABSPATH') || die("No Access");

class AthleteBody extends BaseRepository
{

	public function __construct()
	{
		parent::__construct();
		$this->table = $this->table_prefix . 'athlete_body';
		$this->primary_key = "id";
	}

	public function parse_athlete_body_for_chart($athlete_id): array {
		$athlete = $this->get_athlete_body($athlete_id);

		$result = [];

		foreach ($athlete as $value) {
			$year = PersianDate::convert(new DateTime($value->last_update, wp_timezone()), "Y");
			$result[NumberConvert::convert2english($year)]["weight"] = [
				"1" => "NaN",
				"2" => "NaN",
				"3" => "NaN",
				"4" => "NaN",
				"5" => "NaN",
				"6" => "NaN",
				"7" => "NaN",
				"8" => "NaN",
				"9" => "NaN",
				"10" => "NaN",
				"11" => "NaN",
				"12" => "NaN",
			];
			$result[NumberConvert::convert2english($year)]["height"] = [
				"1" => "NaN",
				"2" => "NaN",
				"3" => "NaN",
				"4" => "NaN",
				"5" => "NaN",
				"6" => "NaN",
				"7" => "NaN",
				"8" => "NaN",
				"9" => "NaN",
				"10" => "NaN",
				"11" => "NaN",
				"12" => "NaN",
			];
		}

		foreach ($athlete as $value) {
			$year = PersianDate::convert(new DateTime($value->last_update, wp_timezone()), "Y");
			$month = PersianDate::convert(new DateTime($value->last_update, wp_timezone()), "M");
			$result[NumberConvert::convert2english($year)]["weight"][NumberConvert::convert2english($month)] = $value->athlete_weight;
			$result[NumberConvert::convert2english($year)]["height"][NumberConvert::convert2english($month)] = $value->athlete_height;
		}

		return $result;

	}

	public function get_athlete_body($athlete_id, $last_update = false)
	{

		if ($last_update)
			return $this->db->get_row($this->db->prepare("
        SELECT athlete.last_update
        FROM {$this->table} athlete
        WHERE athlete.athlete_id=%d
        ORDER BY athlete.last_update DESC 
        ", $athlete_id));

		return $this->query($this->db->prepare("
        SELECT athlete.athlete_weight,athlete.athlete_height,athlete.last_update
        FROM {$this->table} athlete
        WHERE athlete.athlete_id=%d
        ", $athlete_id), true);

	}

	public function new_athlete_body($athlete_id, $athlete_height, $athlete_weight)
	{

		return $this->db->insert(
			$this->table,
			[
				"athlete_id" => $athlete_id,
				"athlete_height" => $athlete_height,
				"athlete_weight" => $athlete_weight,
				"last_update" => current_time("mysql")
			],
			[
				"%d",
				"%f",
				"%f",
				"%s"
			]
		);

	}

}