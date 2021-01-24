<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as Mongo;

/**
 * Class Workplace
 * @package App\Document
 * @Mongo\EmbeddedDocument
 */
class Workplace
{
    /**
     * @Mongo\Id
     */
    private $id;

    /**
     * @Mongo\Field(type="date")
     */
    private $startDate;

    /**
     * @Mongo\Field(type="date")
     */
    private $endDate;

    /**
     * @Mongo\Field(type="string")
     */
    private $organizationName;

    /**
     * @Mongo\Field(type="string")
     */
    private $postName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * @param mixed $startDate
     */
    public function setStartDate($startDate): void
    {
        $this->startDate = $startDate;
    }

    /**
     * @return mixed
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * @param mixed $endDate
     */
    public function setEndDate($endDate): void
    {
        $this->endDate = $endDate;
    }

    /**
     * @return mixed
     */
    public function getOrganizationName()
    {
        return $this->organizationName;
    }

    /**
     * @param mixed $organizationName
     */
    public function setOrganizationName($organizationName): void
    {
        $this->organizationName = $organizationName;
    }

    /**
     * @return mixed
     */
    public function getPostName()
    {
        return $this->postName;
    }

    /**
     * @param mixed $postName
     */
    public function setPostName($postName): void
    {
        $this->postName = $postName;
    }

}