<?php defined('BASEPATH') or exit('No direct script access allowed');

class SSP
{
	static function data_output($columns, $data)
	{
		$out = array();
		if ($data) {
			for ($i = 0, $ien = count($data); $i < $ien; $i++) {
				$row = array();
				for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
					$column = $columns[$j];
					if (isset($column['alias'])) {
						if ($column['alias'] != '') {
							$c = $column['alias'];
						} else {
							$c = $column['db'];
						}
					} else {
						$c = $column['db'];
					}
					if (isset($column['formatter'])) {
						$row[$column['dt']] = ($column['formatter']($data[$i][$c], $data[$i]));
					} else {
						$row[$column['dt']] = ($data[$i][$c]);
					}
				}
				$out[] = $row;
			}
		}
		return $out;
	}

	static function limit($request, $columns)
	{
		$limit = '';
		if (!empty($columns)) {
			if (isset($request['start']) && $request['length'] != -1) {
				$limit = "LIMIT " . intval($request['length']) . " OFFSET " . intval($request['start']);
			}
		}
		return $limit;
	}

	static function order($request, $columns)
	{
		$order = '';
		if (isset($request['order']) && count($request['order'])) {
			$orderBy = array();
			$dtColumns = SSP::pluck($columns, 'dt');
			for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
				// Convert the column index into the column data property
				$columnIdx = intval($request['order'][$i]['column']);
				$requestColumn = $request['columns'][$columnIdx];
				$columnIdx = array_search($requestColumn['data'], $dtColumns);
				$column = $columns[$columnIdx];
				if ($requestColumn['orderable'] == 'true') {
					$dir = $request['order'][$i]['dir'] === 'asc' ?
						'ASC' :
						'DESC';
					$orderBy[] = $column['db'] . ' ' . $dir;
				}
			}
			$order = 'ORDER BY ' . implode(', ', $orderBy);
		}
		return $order;
	}

	static function filter($request, $columns, $filtroAdd)
	{
		$globalSearch = array();
		$columnSearch = array();
		$dtColumns = SSP::pluck($columns, 'dt');
		if (isset($request['search']) && $request['search']['value'] != '') {
			$str = $request['search']['value'];
			$str = pg_escape_string($str);
			for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
				$requestColumn = $request['columns'][$i];
				$columnIdx = array_search($requestColumn['data'], $dtColumns);
				$column = $columns[$columnIdx];
				if ($requestColumn['searchable'] == 'true') {
					$globalSearch[] = " {$column['db']}::varchar ILIKE '%$str%'";
				}
			}
		}
		for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
			$requestColumn = $request['columns'][$i];
			$columnIdx = array_search($requestColumn['data'], $dtColumns);
			$column = $columns[$columnIdx];
			$str = $requestColumn['search']['value'];
			$str = pg_escape_string($str);
			if (
				$requestColumn['searchable'] == 'true' &&
				$str != ''
			) {
				$columnSearch[] = " {$column['db']}::varchar ILIKE '%$str%'";
			}
		}
		$where = '';
		if (count($globalSearch)) {
			$where = '(' . implode(' OR ', $globalSearch) . ')';
		}
		if (count($columnSearch)) {
			$where = $where === '' ?
				implode(' AND ', $columnSearch) :
				$where . ' AND ' . implode(' AND ', $columnSearch);
		}
		if ($filtroAdd !== NULL) {
			if ($where !== '') {
				$where = $filtroAdd . ' AND ' . $where;
			} else {
				$where = $filtroAdd;
			}
		}
		if ($where !== '') {
			$where = 'WHERE ' . $where;
		}
		return $where;
	}

	static function simple($request, $pg_details, $table, $primaryKey, $columns, $filtroAdd = NULL)
	{
		$db = SSP::pg_connect($pg_details);

		// Build the SQL query string from the request
		$table = (substr($table, 0, 4) === 'psg_' ? '' : 'psg_') . $table;
		$limit = SSP::limit($request, $columns);
		$order = SSP::order($request, $columns);
		$where = SSP::filter($request, $columns, $filtroAdd);
		$select = "SELECT " . implode(", ", SSP::pluckas($columns)) . "
			 , count(*) OVER() AS full_count
			 FROM $table			 
			 $where
			 $order
			 $limit";
		//Debug
		//echo "Consulta para la tabla: $select<br>";
		pg_query($db, "SET search_path = principal, public, academico, administrativo, financiero, correspondencia, rrhh, marketing");
		$result = pg_query($db, $select) or SSP::fatal("Error al ejecutar la consulta.\n" . pg_last_error() . "\n $select");
		$data = pg_fetch_all($result);
		//Debug
		// Main query to actually get the data
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die();
		$recordsFiltered = $data == false ? 0 : $data[0]['full_count'];
		if ($filtroAdd !== NULL) {
			$where = " WHERE $filtroAdd ";
		} else {
			$where = "";
		}
		$resTotalLength = pg_query($db, "SELECT COUNT(" . $primaryKey . ") cuenta FROM " . $table . " " . $where);
		$recordsTotalRow = pg_fetch_row($resTotalLength);
		$recordsTotal = $recordsTotalRow[0];
		pg_free_result($result);
		pg_free_result($resTotalLength);
		return array(
			"draw" => intval($request['draw']),
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => SSP::data_output($columns, $data)
		);
	}

	static function complex($request, $pg_details, $table, $primaryKey, $columns, $filtroAdd = NULL, $whereResult = null, $whereAll = null)
	{
		$db = SSP::pg_connect($pg_details);
		$localWhereResult = array();
		$localWhereAll = array();
		$whereAllSql = '';

		// Build the SQL query string from the request
		$table = (substr($table, 0, 4) === 'psg_' ? '' : 'psg_') . $table;
		$limit = SSP::limit($request, $columns);
		$order = SSP::order($request, $columns);
		$where = SSP::filter($request, $columns, $filtroAdd);
		$whereResult = self::_flatten($whereResult);
		$whereAll = self::_flatten($whereAll);
		if ($whereResult) {
			$where = $where ?
				$where . ' AND ' . $whereResult :
				'WHERE ' . $whereResult;
		}
		if ($whereAll) {
			$where = $where ?
				$where . ' AND ' . $whereAll :
				'WHERE ' . $whereAll;
			$whereAllSql = 'WHERE ' . $whereAll;
		}
		$select = "SELECT " . implode(", ", SSP::pluckas($columns)) . "
			 , count(*) OVER() AS full_count
			 FROM $table			 
			 $where
			 $order
			 $limit";
		//Debug
		//echo "Consulta para la tabla: $select<br>";
		pg_query($db, "SET search_path = principal, public, academico, administrativo, financiero, correspondencia, marketing");
		$result = pg_query($db, $select) or SSP::fatal("Error al ejecutar la consulta.\n" . pg_last_error() . "\n $select");
		$data = pg_fetch_all($result);
		//Debug
		// Main query to actually get the data
		// echo "<pre>";
		// print_r($data);
		// echo "</pre>";
		// die();

		$recordsFiltered = $data == false ? 0 : $data[0]['full_count'];
		if ($filtroAdd !== NULL) {
			$where = " WHERE $filtroAdd ";
		} else {
			$where = "";
		}
		$resTotalLength = pg_query($db, "SELECT COUNT(" . $primaryKey . ") cuenta FROM " . $table . " " . $where);
		$recordsTotalRow = pg_fetch_row($resTotalLength);
		$recordsTotal = $recordsTotalRow[0];
		pg_free_result($result);
		pg_free_result($resTotalLength);
		return array(
			"draw" => intval($request['draw']),
			"recordsTotal" => intval($recordsTotal),
			"recordsFiltered" => intval($recordsFiltered),
			"data" => SSP::data_output($columns, $data)
		);
	}

	static function pg_connect($pg_details)
	{
		$db = pg_connect("
			host={$pg_details['host']} 
			dbname={$pg_details['db']} 
			user={$pg_details['user']} 
			password={$pg_details['pass']}") or SSP::fatal("Error en conexión a DB.\n" . pg_last_error());
		return $db;
	}

	/**
	 * Execute an SQL query on the database
	 *
	 * @param  resource $db  Database handler
	 * @param  array    $bindings Array of PDO binding values from bind() to be
	 *   used for safely escaping strings. Note that this can be given as the
	 *   SQL query string if no bindings are required.
	 * @param  string   $sql SQL query to execute.
	 * @return array         Result from the query (all rows)
	 */
	static function sql_exec($db, $bindings, $sql = null)
	{
		// Argument shifting
		if ($sql === null) {
			$sql = $bindings;
		}
		$stmt = $db->prepare($sql);
		//echo $sql;
		// Bind parameters
		if (is_array($bindings)) {
			for ($i = 0, $ien = count($bindings); $i < $ien; $i++) {
				$binding = $bindings[$i];
				$stmt->bindValue($binding['key'], $binding['val'], $binding['type']);
			}
		}
		// Execute
		try {
			$stmt->execute();
		} catch (PDOException $e) {
			self::fatal("An SQL error occurred: " . $e->getMessage());
		}
		// Return all
		return $stmt->fetchAll(PDO::FETCH_BOTH);
	}

	static function fatal($msg)
	{
		echo json_encode(array("error" => $msg));
		exit(0);
	}

	static function pluck($a, $prop)
	{
		$out = array();
		for ($i = 0, $len = count($a); $i < $len; $i++) {
			$out[] = $a[$i][$prop];
		}
		return $out;
	}

	static function pluckas($a)
	{
		$out = array();
		for ($i = 0, $len = count($a); $i < $len; $i++) {
			if (isset($a[$i]['alias'])) {
				if ($a[$i]['alias'] != '') {
					$out[] = $a[$i]['db'] . " AS " . $a[$i]['alias'];
				} else {
					$out[] = $a[$i]['db'];
				}
			} else {
				$out[] = $a[$i]['db'];
			}
		}
		return $out;
	}

	/**
	 * Return a string from an array or a string
	 *
	 * @param  array|string $a Array to join
	 * @param  string $join Glue for the concatenation
	 * @return string Joined string
	 */
	static function _flatten($a, $join = ' AND ')
	{
		if (!$a) {
			return '';
		} else if ($a && is_array($a)) {
			return implode($join, $a);
		}
		return $a;
	}
}