<?php

namespace App\theme\repository;

use App\theme\repository\contract\BaseRepository;

defined('ABSPATH') || die("No Access");

class OrderRepository extends BaseRepository
{

	public function __construct()
	{
		parent::__construct();
		$this->table = $this->table_prefix . 'orders';
		$this->primary_key = "id";
	}

	public function is_exist($athlete_id, $coach_id, $type_program)
	{

		return $this->db->query($this->db->prepare("
        SELECT orders.id
        FROM {$this->table} orders
        WHERE orders.athlete_id=%d AND orders.coach_id=%d AND orders.type_program=%s
        ", [$athlete_id, $coach_id, $type_program]));

	}

	public function new_order($athlete_id, $coach_id, $type_program)
	{

		if ($this->is_exist($athlete_id, $coach_id, $type_program))
			return $this->db->update(
				$this->table,
				[
					"active" => 1
				],
				[
					"athlete_id" => $athlete_id,
					"coach_id" => $coach_id,
					"type_program" => $type_program
				],
				[
					"%d"
				],
				[
					"%d",
					"%d",
					"%s"
				]
			);

		return $this->db->insert(
			$this->table,
			[
				"athlete_id" => $athlete_id,
				"coach_id" => $coach_id,
				"type_program" => $type_program
			],
			[
				"%d",
				"%d",
				"%s"
			]
		);

	}

	public function activate_rate($order_id)
	{
		return $this->db->update(
			$this->table,
			["can_rate" => 1],
			["id" => $order_id],
			["%d"],
			["%d"]
		);
	}

	public function deactivate_rate($order_id)
	{
		return $this->db->update(
			$this->table,
			["can_rate" => 0],
			["id" => $order_id],
			["%d"],
			["%d"]
		);
	}

	public function deactivate_order($order_id)
	{
		return $this->db->update(
			$this->table,
			["active" => 0],
			["id" => $order_id],
			["%d"],
			["%d"]
		);
	}

	public function get_orders_for_coach($coach_id, $offset, $per_page)
	{
		return $this->query($this->db->prepare("
        SELECT *
        FROM {$this->table} orders
        WHERE orders.coach_id=%d
        ORDER BY orders.active DESC
        LIMIT %d,%d
        ", [$coach_id, $offset, $per_page]), true);
	}

	public function get_orders_for_athlete($athlete_id, $offset, $per_page)
	{
		return $this->query($this->db->prepare("
        SELECT *
        FROM {$this->table} orders
        WHERE orders.athlete_id=%d
        LIMIT %d,%d
        ", [$athlete_id, $offset, $per_page]), true);
	}

	public function get_count_orders_for_athlete($athlete_id)
	{
		return $this->query($this->db->prepare("
        SELECT orders.id
        FROM {$this->table} orders
        WHERE orders.athlete_id=%d
        ", $athlete_id), false);
	}

	public function get_count_orders_for_coach($coach_id)
	{
		return $this->query($this->db->prepare("
        SELECT orders.id
        FROM {$this->table} orders
        WHERE orders.coach_id=%d
        ", $coach_id), false);
	}

	public function check_activate_order($athlete_id, $coach_id, $type_program)
	{
		return $this->db->query($this->db->prepare("
        SELECT orders.id
        FROM {$this->table} orders
        WHERE orders.athlete_id=%d AND orders.coach_id=%d AND orders.type_program=%s AND orders.active=%d
        ", [$athlete_id, $coach_id, $type_program, 1]));
	}

}