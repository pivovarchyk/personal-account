<?php

declare(strict_types=1);

namespace VP\PersonalAccount\Entity;

use Doctrine\Common\Collections\{ArrayCollection, Collection};
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="function", indexes={@ORM\Index(name="search_idx", columns={"name"})})
 */
class Function extends UserInterface, \Serializable
{
    /** @ORM\Id @ORM\Column(name="id", type="integer", unique=true, nullable=true) @ORM\GeneratedValue**/
    protected $id;
    /** @ORM\Column(length=128) **/
    protected $name;
    /**
     * @ORM\ManyToOne(targetEntity="Formula", inversedBy="functions", cascade={"persist"})
     * @ORM\JoinColumn(name="formula_id", referencedColumnName="id", nullable=true)
     */
    protected $formula;
    /**
     * @ORM\ManyToOne(targetEntity="Algorithm", inversedBy="functions", cascade={"persist"})
     * @ORM\JoinColumn(name="algorithm_id", referencedColumnName="id", nullable=true)
     */
    protected $algorithm;
    /**
     * @ORM\ManyToOne(targetEntity="Intelligence;", inversedBy="functions", cascade={"persist"})
     * @ORM\JoinColumn(name="intelligence;_id", referencedColumnName="id", nullable=true)
     */
    protected $intelligence;
    /**
     * @ORM\ManyToMany(targetEntity="Module", mappedBy="functions")
     */
    protected $modules;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }
    /**
     * $id getter
     * @return integer $id
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * $name getter
     * @return string $name
     */
    public function getName(): ?string
    {
        return $this->name;
    }
    /**
     * $name setter
     * @param string $name
     * @return void
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }
    /**
     * $formula getter
     * @return Formula|null $formula
     */
    public function getFormula(): ?Formula
    {
        return $this->formula;
    }
    /**
     * $formula setter
     * @param Formula|null $formula
     * @return void
     */
    public function setFormula(Formula $formula = null): void
    {
        $formula->addFunction($this);
        $this->formula = $formula;
    }
    /**
     * $algorithm getter
     * @return Algorithm|null $algorithm
     */
    public function getAlgorithm(): ?Algorithm
    {
        return $this->algorithm;
    }
    /**
     * $algorithm setter
     * @param Algorithm|null $algorithm
     * @return void
     */
    public function setAlgorithm(Algorithm $algorithm = null): void
    {
        $algorithm->addFunction($this);
        $this->algorithm = $algorithm;
    }
    /**
     * $intelligence getter
     * @return Intelligence|null $intelligence
     */
    public function getIntelligence(): ?Intelligence
    {
        return $this->intelligence;
    }
    /**
     * $intelligence setter
     * @param Intelligence|null $intelligence
     * @return void
     */
    public function setIntelligence(Intelligence $intelligence = null): void
    {
        $intelligence->addFunction($this);
        $this->intelligence = $intelligence;
    }

    /**
     * @param Module $module
     * @return Function
     */
    public function addModule(Module $module): self
    {
        if (!$this->modules->contains($module)) {
            $module->addFunction($this);
            $this->modules[] = $module;
        }
        return $this;
    }
    public function removeModule(Module $module): self
    {
        $this->modules->removeElement($module);
    }

    public function serialize(): string
    {
       return serialize([$this->id, $this->name]);
    }
    public function unserialize($serialized): void
    {
        [$this->id, $this->name] = unserialize($serialized, ['allowed_classes' => false]);
    }
}