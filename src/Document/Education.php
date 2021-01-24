<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as Mongo;

/**
 * Class Education
 * @package App\Document
 * @Mongo\EmbeddedDocument
 */
class Education
{
    /**
     * @Mongo\Id
     */
    private $id;

    /**
     * @Mongo\Field(type="string")
     */
    private $institution;

    /**
     * @Mongo\Field(type="string")
     */
    private $faculty;

    /**
     * @Mongo\Field(type="string")
     */
    private $speciality;

    /**
     * @Mongo\Field(type="integer")
     */
    private $graduated;

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
    public function getInstitution()
    {
        return $this->institution;
    }

    /**
     * @param mixed $institution
     */
    public function setInstitution($institution): void
    {
        $this->institution = $institution;
    }

    /**
     * @return mixed
     */
    public function getFaculty()
    {
        return $this->faculty;
    }

    /**
     * @param mixed $faculty
     */
    public function setFaculty($faculty): void
    {
        $this->faculty = $faculty;
    }

    /**
     * @return mixed
     */
    public function getSpeciality()
    {
        return $this->speciality;
    }

    /**
     * @param mixed $speciality
     */
    public function setSpeciality($speciality): void
    {
        $this->speciality = $speciality;
    }

    /**
     * @return mixed
     */
    public function getGraduated()
    {
        return $this->graduated;
    }

    /**
     * @param mixed $graduated
     */
    public function setGraduated($graduated): void
    {
        $this->graduated = $graduated;
    }

}