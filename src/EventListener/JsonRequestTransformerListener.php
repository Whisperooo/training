<?php

namespace App\EventListener;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class JsonRequestTransformerListener
{
    public function onKernelRequest(RequestEvent $event)
    {
        $req = $event->getRequest();
        $content = $req->getContent();

        if (empty($content) || !$this->isJsonRequest($req)) {
            return;
        }

        if (!$this->transformJsonBody($req)) {
            throw new BadRequestHttpException('error.request.json-malformed');
        }
    }

    private function isJsonRequest(Request $request): bool
    {
        return true;
    }

    private function transformJsonBody(Request $request): bool
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return false;
        }

        if ($data === null) {
            return true;
        }

        $request->request->replace($data);
        return true;
    }
}
