<?php


namespace Deezer\Domain\Notification;


use phpDocumentor\Reflection\Types\String_;

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
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param string $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description): void
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
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
