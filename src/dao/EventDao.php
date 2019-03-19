<?php

namespace App\Dao;

use App\Model\Event;
use App\Dao\BaseDao;
use PDO;

class EventDao extends BaseDao
{
    public function count()
    {
        $req = $this->db->prepare('SELECT COUNT(*) AS nbevents FROM events');
        $req->execute([]);
        return (int)$req->fetch()['nbevents'];
    }

    public function eventPage($offset, $limit)
    {
        $conditionLimit = (isset($offset)) ? " LIMIT {$offset},{$limit}" : "";
        $req = $this->db->prepare('SELECT * FROM events ORDER BY id' . $conditionLimit);
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, Event::class);
    }

    public function lastEvent()
    {
        $req = $this->db->prepare('SELECT * FROM events ORDER BY id DESC LIMIT 1');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, Event::class);
    }

    public function findEvents()
    {
        $req = $this->db->prepare('SELECT * FROM events ORDER BY id');
        $req->execute();
        return $req->fetchAll(PDO::FETCH_CLASS, Event::class);
    }

    public function find($id)
    {
        $req = $this->db->prepare('SELECT * FROM events WHERE id=?');
        $req->setFetchMode(PDO::FETCH_CLASS, Event::class);
        $req->execute([$id]);
        return $req->fetch();
    }

    public function update($id, $title, $states, $image, $legend)
    {
        $query = $this->db->prepare('UPDATE events SET title=:title , states=:states, image=:image, legend=:legend  WHERE id=:id');
        $query->execute(['id' => $id, 'title' => $title, 'states' => $states, 'image' => $image, 'legend' => $legend]);
        return;
    }

    public function delete($id)
    {
        $query = $this->db->prepare('DELETE FROM events WHERE id=?');
        $query->execute([$id]);
        return;
    }

    public function insert($id, $title, $states, $image, $legend)
    {
        $result = $this->db->prepare('INSERT INTO events(id, title, states, image, legend, event_date) VALUES(:id, :title, :states, :image, :legend, NOW())');
        $result->execute(['id' => $id, 'title' => $title, 'states' => $states, 'image' => $image, 'legend' => $legend]);
    }
}
