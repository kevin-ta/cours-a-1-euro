<?php
namespace Zephyr\CoursBundle\Form\DataTransformer;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Doctrine\Common\Persistence\ObjectManager;
use Zephyr\CoursBundle\Entity\Unit;
class UnitToNameTransformer implements DataTransformerInterface
{
    /**
     * @var ObjectManager
     */
    private $om;
    /**
     * @param ObjectManager $om
     */
    public function __construct(ObjectManager $om)
    {
        $this->om = $om;
    }
    public function transform($unit)
    {
        if (null === $unit) {
            return "";
        }
        return $unit->getName();
    }
    public function reverseTransform($name)
    {
        if (!$name) {
            return null;
        }
        $unit = $this->om
            ->getRepository('ZephyrCoursBundle:Unit')
            ->findOneBy(array('name' => $name))
        ;
        if (null === $unit) {
            throw new TransformationFailedException(sprintf(
                '"%s" ne peut pas être trouvé.',
                $name
            ));
        }
        return $unit;
    }
}