<?php


namespace Deezer\Domain\Notification;


class Notification
{

    private $author;
    private $content;
    private $description;
    private $type;
    private $period;

    /**
     * Notification constructor.
     * @param $author
     * @param $content
     * @param $description
     * @param $type
     * @param $period
     */
    public function __construct($author = null, $content = null, $description = null, $type = null, $period = null)
    {
        $this->author = $author;
        $this->content = $content;
        $this->description = $description;
        $this->period = $period;
        $this->type = $type;
    }

    /**
     * @return null
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param null $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return null
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param null $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param null $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param null $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }

    /**
     * @return null
     */
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * @param null $period
     */
    public function setPeriod($period): void
    {
        $this->period = $period;
    }

}
