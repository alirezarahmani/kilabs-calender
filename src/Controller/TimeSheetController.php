<?php
declare(strict_types=1);
namespace App\Controller;

use App\Domain\Entity\TimeSheetEntity;
use App\Domain\Model\FreeTimeFactory;
use App\Domain\Model\HourlyTimeFormat;
use App\Infrastructure\Request\ApiRequestInterface;
use App\Infrastructure\Response\ApiResponseInterface;
use App\Infrastructure\Validator\FreeTimeApiValidator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TimeSheetController extends AbstractController
{
    /**
     * @param ApiRequestInterface    $request
     * @param ApiResponseInterface   $apiResponse
     * @param EntityManagerInterface $entityManager
     */
    public function create(ApiRequestInterface $request, ApiResponseInterface $apiResponse)
    {
        try {
            (new FreeTimeFactory($this->getDoctrine()->getManager()))->set(
                $request->getRequest()->query->getIterator()->getArrayCopy(),
                new FreeTimeApiValidator(),
                $this->getDoctrine()->getManager()->getRepository(TimeSheetEntity::class),
                new HourlyTimeFormat()
            );
            $apiResponse->success();
        } catch (\InvalidArgumentException $argumentException) {
            $apiResponse->error($argumentException->getMessage());
        }
    }
}
