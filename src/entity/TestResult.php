<?php

namespace Pendella\SpeedTest\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="test_result")
 */
class TestResult {

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="CompanyProductURL")
     * @ORM\JoinColumn(name="url_id", referencedColumnName="id")
     */
    private $url;

    /**
     * @ORM\Column(type="datetime")
     */
    private $testDate;

    /**
     * @ORM\Column(type="string", length="50")
     */
    private $testType;

    /**
     * @ORM\Column(type="string", length="50")
     */
    private $resTitle;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $score;

    /**
     * @ORM\Column(type="string", length="50")
     */
    private $displayValue;

    /**
     * @return int
     */
    function getId() {
        return $this->id;
    }

    /**
     * @return CompanyProductURL
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param CompanyProductURL $url
     * @return TestResult
     */
    public function setUrl(CompanyProductURL $url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTestDate()
    {
        return $this->testDate;
    }

    /**
     * @param mixed $testDate
     * @return TestResult
     */
    public function setTestDate($testDate)
    {
        $this->testDate = $testDate;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTestType()
    {
        return $this->testType;
    }

    /**
     * @param mixed $testType
     * @return TestResult
     */
    public function setTestType($testType)
    {
        $this->testType = $testType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResTitle()
    {
        return $this->resTitle;
    }

    /**
     * @param mixed $resTitle
     * @return TestResult
     */
    public function setResTitle($resTitle)
    {
        $this->resTitle = $resTitle;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getScore()
    {
        return $this->score;
    }

    /**
     * @param mixed $score
     * @return TestResult
     */
    public function setScore($score)
    {
        $this->score = $score;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDisplayValue()
    {
        return $this->displayValue;
    }

    /**
     * @param mixed $displayValue
     * @return TestResult
     */
    public function setDisplayValue($displayValue)
    {
        $this->displayValue = $displayValue;
        return $this;
    }
}
