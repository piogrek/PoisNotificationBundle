<?php

namespace Pois\NotificationBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Notification controller.
 *
 * @Route("/notifications")
 */
class NotificationController extends Controller
{



    /**
     * Displays a form to create a new Message entity.
     *
     * @Route("/new", name="notification_new")
     * @Template()
     */
    public function newAction(Request $request)
    {
        return array(
            'id'      => $request->get('id'),
            'id_name' => $request->get('id_name'),
            'notification_types' => $this->get('g_service.notification.type')->getAllForArtykul()
        );
    }

    /**
     * Creates a new Message entity.
     *
     * @Route("/create", name="notification_create")
     * @Method("POST")
     */
    public function createAction(Request $request)
    {
        $userId = $this->get('security.context')->getToken()->getUser()->getId();

        $notificationType = $this->get('g_service.notification.type')->get($request->get('notification_type_id'));

        $params = array();
        //alert jesli stan mniejszy niz
        $params['stanMinimalny'] = $request->get('stan_minimalny');

        //alert jesli waznosc ponizej dni
        $params['expiryInDays'] = $request->get('expiry_in_days');



        //recognise request and redirect to correct service
        if ( $id = $request->get('client_id') ) {
             $this->get('g_service.client')->addNotification($id, $userId, $notificationType, $params);
        } elseif ( $id = $request->get('dokument_id') ) {
            $this->get('g_service.magazyn')->addNotification($id, $userId, $notificationType, $params);
        } elseif ( $id = $request->get('artykul_id') ) {
            $this->get('g_service.magazyn.artykul')->addNotification($id, $userId, $notificationType, $params);
        } elseif ( $id = $request->get('imlorder_id') ) {
            $this->get('g_service.imlorder')->addNotification($id, $userId, $notificationType, $params);
        } elseif ( $id = $request->get('calculation_id') ) {
            $this->get('g_service.calculation')->addNotification($id, $userId, $notificationType, $params);
        } elseif ( $id = $request->get('user_id') ) {
            $this->get('g_service.user')->addNotification($id, $userId, $notificationType, $params);
        } else {
            throw $this->createNotFoundException("Nie znaleziono obiektu dla zalacznika ({$id_name} = {$id})");
        }

        //return json
        if ($request->isXmlHttpRequest()) {
            $result = array('success' => true);
            $response = new Response(json_encode($result));
            $response->headers->set('Content-Type', 'application/json');
            return $response;
        } else {
            throw $this->createNotFoundException('No direct view for this page');
        }

    }


    /**
     * Toggle subscription
     *
     * @Route("/{id}/subscribe", name="notification_subscribe")
     */
    public function subscribeAction(Request $request, $id)
    {
        $user_id = $this->get('security.context')->getToken()->getUser()->getId();
        $result = $this->get('g_service.subscription')->subscribeToNotificationToggle($id, $user_id);

        $response = new Response($result?'Zrezygnuj':'Subskrybuj');
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }

    /**
     * Delete notification
     *
     * @Route("/{id}/delete", name="notification_delete")
     * @Template()
     */
    public function deleteAction(Request $request, $id)
    {

        if ($request->isMethod('POST')) {

            $this->get('g_service.notification')->delete($id);

            //return json
            if ($request->isXmlHttpRequest()) {
                $result = array('success' => true);
                $response = new Response(json_encode($result));
                $response->headers->set('Content-Type', 'application/json');
                return $response;
            } else {
                throw $this->createNotFoundException('No direct view for this page');
            }
        } else {
            return array(
                'delete_form' => $this->createDeleteForm($id)->createView(),
                'entity'      => $this->get('g_service.notification')->get($id)
            );
        }
    }


    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}
