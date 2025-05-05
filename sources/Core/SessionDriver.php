<?php

namespace App\Core;

use SessionHandlerInterface;

class SessionDriver implements SessionHandlerInterface{

	private const string SESSION_CREATE_TABLE_QUERY = "CREATE TABLE IF NOT EXISTS `session_store` (id TEXT PRIMARY KEY NOT NULL, access INTEGER NOT NULL, data TEXT, device TEXT)";
	private const string SESSION_READ_QUERY = "SELECT data FROM `session_store` WHERE id = ?";
	private const string SESSION_WRITE_QUERY = "INSERT INTO `session_store` (id, access, data, device) VALUES (?, ?, ?, ?) ";
	private const string SESSION_DESTROY_QUERY = "DELETE FROM `session_store` WHERE id = ?";
	private const string SESSION_GC_QUERY = "DELETE FROM `session_store` WHERE access < ?";

	public function __construct(){
		$create = Database::query(self::SESSION_CREATE_TABLE_QUERY)->fetchAll()->result();
		if(!$create['status']){
			Logging::record("error","Failed to create session table!",self::class);
			Routing::internalError();
		}
	}

	public function open(string $savePath, $sessionName):bool{
		return true;
	}

	public function close():bool{
		return true;
	}

	public function read(string $id):string{
		$read = Database::query(self::SESSION_READ_QUERY, [$id])->fetchAll()->result();
		return $read['status'] ? $read['fetchAll'][0]['data'] ?? "" : "";
	}

	public function write(string $id, string $data):bool{
		$write = Database::query(self::SESSION_WRITE_QUERY, [$id, time(), $data])->result();
		return $write['status'];
	}

	public function destroy(string $id):bool{
		$destroy = Database::query(self::SESSION_DESTROY_QUERY, [$id])->result();
		return $destroy['status'];
	}

	public function gc(int $maxlifetime):int|false{
		$gc = Database::query(self::SESSION_GC_QUERY, [time() - $maxlifetime])->result();
		return $gc['status'];
	}
}