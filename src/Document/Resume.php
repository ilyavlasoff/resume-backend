<?php

namespace App\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as Mongo;

/**
 * Class Resume
 * @package App\Document
 * @Mongo\Document
 */
class Resume
{
    /**
     * @Mongo\Id(strategy="INCREMENT", type="integer")
     */
    private $id;

    /**
     * @Mongo\Field(type="string")
     */
    private $firstName;

    /**
     * @Mongo\Field(type="string")
     */
    private $lastName;

    /**
     * @Mongo\Field(type="string")
     */
    private $patronymic;

    /**
     * @Mongo\Field(type="string")
     */
    private $gender;

    /**
     * @Mongo\Field(type="date")
     */
    private $birthday;

    /**
     * @Mongo\Field(type="string")
     */
    private $country;

    /**
     * @Mongo\Field(type="string")
     */
    private $city;

    /**
     * @Mongo\Field(type="string")
     */
    private $photo;

    /**
     * @Mongo\Field(type="string")
     */
    private $experienceLevel;

    /**
     * @Mongo\Field(type="collection")
     */
    private $workplaces;

    /**
     * @Mongo\Field(type="string")
     */
    private $educationLevel;

    /**
     * @Mongo\Field(type="collection")
     */
    private $educations;

    /**
     * @Mongo\Field(type="string")
     */
    private $phoneNumber;

    /**
     * @Mongo\Field(type="string")
     */
    private $email;

    /**
     * @Mongo\Field(type="string")
     */
    private $sphere;

    /**
     * @Mongo\Field(type="string")
     */
    private $desiredPost;

    /**
     * @Mongo\Field(type="float")
     */
    private $salaryMin;

    /**
     * @Mongo\Field(type="float")
     */
    private $salaryMax;

    /**
     * @Mongo\Field(type="string")
     */
    private $skills;

    /**
     * @Mongo\Field(type="string")
     */
    private $personalQualities;

    /**
     * @Mongo\Field(type="string")
     */
    private $aboutMyself;

    /**
     * @Mongo\Field(type="string")
     */
    private $status;

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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * @param mixed $patronymic
     */
    public function setPatronymic($patronymic): void
    {
        $this->patronymic = $patronymic;
    }

    /**
     * @return mixed
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @param mixed $gender
     */
    public function setGender($gender): void
    {
        $this->gender = $gender;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @param mixed $birthday
     */
    public function setBirthday($birthday): void
    {
        $this->birthday = $birthday;
    }

    /**
     * @return mixed
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @param mixed $country
     */
    public function setCountry($country): void
    {
        $this->country = $country;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city): void
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo): void
    {
        $this->photo = $photo;
    }

    /**
     * @return mixed
     */
    public function getExperienceLevel()
    {
        return $this->experienceLevel;
    }

    /**
     * @param mixed $experienceLevel
     */
    public function setExperienceLevel($experienceLevel): void
    {
        $this->experienceLevel = $experienceLevel;
    }

    /**
     * @return mixed
     */
    public function getWorkplaces()
    {
        return $this->workplaces;
    }

    /**
     * @param mixed $workplaces
     */
    public function setWorkplaces($workplaces): void
    {
        $this->workplaces = $workplaces;
    }

    /**
     * @return mixed
     */
    public function getEducationLevel()
    {
        return $this->educationLevel;
    }

    /**
     * @param mixed $educationLevel
     */
    public function setEducationLevel($educationLevel): void
    {
        $this->educationLevel = $educationLevel;
    }

    /**
     * @return mixed
     */
    public function getEducations()
    {
        return $this->educations;
    }

    /**
     * @param mixed $educations
     */
    public function setEducations($educations): void
    {
        $this->educations = $educations;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getSphere()
    {
        return $this->sphere;
    }

    /**
     * @param mixed $sphere
     */
    public function setSphere($sphere): void
    {
        $this->sphere = $sphere;
    }

    /**
     * @return mixed
     */
    public function getDesiredPost()
    {
        return $this->desiredPost;
    }

    /**
     * @param mixed $desiredPost
     */
    public function setDesiredPost($desiredPost): void
    {
        $this->desiredPost = $desiredPost;
    }

    /**
     * @return mixed
     */
    public function getSalaryMin()
    {
        return $this->salaryMin;
    }

    /**
     * @param mixed $salaryMin
     */
    public function setSalaryMin($salaryMin): void
    {
        $this->salaryMin = $salaryMin;
    }

    /**
     * @return mixed
     */
    public function getSalaryMax()
    {
        return $this->salaryMax;
    }

    /**
     * @param mixed $salaryMax
     */
    public function setSalaryMax($salaryMax): void
    {
        $this->salaryMax = $salaryMax;
    }

    /**
     * @return mixed
     */
    public function getSkills()
    {
        return $this->skills;
    }

    /**
     * @param mixed $skills
     */
    public function setSkills($skills): void
    {
        $this->skills = $skills;
    }

    /**
     * @return mixed
     */
    public function getPersonalQualities()
    {
        return $this->personalQualities;
    }

    /**
     * @param mixed $personalQualities
     */
    public function setPersonalQualities($personalQualities): void
    {
        $this->personalQualities = $personalQualities;
    }

    /**
     * @return mixed
     */
    public function getAboutMyself()
    {
        return $this->aboutMyself;
    }

    /**
     * @param mixed $aboutMyself
     */
    public function setAboutMyself($aboutMyself): void
    {
        $this->aboutMyself = $aboutMyself;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

}
