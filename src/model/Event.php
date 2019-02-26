<?php

namespace App\Model;

class Event implements \JsonSerializable
{

    private $id;
    private $title;
    private $states;
    private $eimage;
    private $legend;
    private $eventDate;
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Event
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return Event
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * @param mixed $states
     * @return Event
     */
    public function setStates($states)
    {
        $this->states = $states;
        return $this;
    }

/**
     * @return mixed
     */
    public function getEimage()
    {
        return $this->eimage;
    }

    /**
     * @param mixed $eimage
     * @return Event
     */
    public function setEimage($eimage)
    {
        $this->eimage = $eimage;
        return $this;
    }

/**
     * @return mixed
     */
    public function getLegend()
    {
        return $this->legend;
    }

    /**
     * @param mixed $legend
     * @return Event
     */
    public function setLegend($legend)
    {
        $this->legend = $legend;
        return $this;
    }

/**
     * @return mixed
     */
    public function getEventtDate()
    {
        return $this->eventDate;
    }

    /**
     * @param mixed $eventDate
     * @return Event
     */
    public function setEventDate($eventDate)
    {
        $this->content = $eventDate;
        return $this;
    }



    /**
     * Specify data which should be serialized to JSON
     * @link http://php.net/manual/en/jsonserializable.jsonserialize.php
     * @return mixed data which can be serialized by <b>json_encode</b>,
     * which is a value of any type other than a resource.
     * @since 5.4.0
     */
    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'states' => $this->states,
            'eimage' => $this->eimage,
            'legend'=> $this->legend,
            'event_date'=> $this->setEventDate  
              ];
    }
}
