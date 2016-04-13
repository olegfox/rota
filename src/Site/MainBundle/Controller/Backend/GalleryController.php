<?php

namespace Site\MainBundle\Controller\Backend;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Site\MainBundle\Entity\Gallery;
use Site\MainBundle\Entity\GalleryElementVideo;
use Site\MainBundle\Entity\GalleryElementPhoto;
use Site\MainBundle\Form\GalleryPhotosType;
use Site\MainBundle\Form\GalleryVideoType;
use Site\MainBundle\VideoParser\VideoParser;

/**
 * Gallery controller.
 *
 */
class GalleryController extends Controller
{

    /**
     * Lists all Gallery entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('SiteMainBundle:Gallery')->findAll();

        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $entities,
            $this->get('request')->query->get('page', 1) /*page number*/,
            10/*limit per page*/
        );

        return $this->render('SiteMainBundle:Backend/Gallery:index.html.twig', array(
            'entities' => $pagination,
        ));
    }

    /**
     * Creates a new Gallery entity.
     *
     */
    public function createAction(Request $request, $type)
    {
        $entity = new Gallery();

        if ("photos" == $type) {
            $form = $this->createCreatePhotosForm($entity);
            $template = 'SiteMainBundle:Backend/Gallery:new_photos.html.twig';
        } elseif ("video" == $type) {
            $form = $this->createCreateVideoForm($entity);
            $template = 'SiteMainBundle:Backend/Gallery:new_video.html.twig';
        }

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if ("photos" == $type) {
//              Добавляем фотки в фотогалерею
                $imagesJson = $request->get('gallery');
                if ($imagesJson) {

                    $images = json_decode($imagesJson);

                    foreach ($images as $image) {
                        $galleryElementPhoto = new GalleryElementPhoto();
                        $galleryElementPhoto->setLink("uploads/media/" . $image);
                        $galleryElementPhoto->setGallery($entity);
                        $em->persist($galleryElementPhoto);
                    }

                }
            } elseif ("video" == $type) {
//              Добавляеем видео
                if($entity->getVideoUrl()){

                    $video = VideoParser::getVideo($entity->getVideoUrl());

                    $galleryElementVideo = new GalleryElementVideo();
                    $galleryElementVideo->setTitle($video->title);
                    $galleryElementVideo->setLink($entity->getVideoUrl());
                    $galleryElementVideo->setOriginal($video->url);
                    $galleryElementVideo->setPreviewImageUrl($video->thumbnail_url);
                    $galleryElementVideo->setHtml($video->html);
                    $galleryElementVideo->setGallery($entity);

                    $em->persist($galleryElementVideo);

                }
            }

            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('backend_gallery_edit', array('id' => $entity->getId(), 'type' => $type)));
        }

        return $this->render($template, array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * @param Gallery $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreatePhotosForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryPhotosType(), $entity, array(
            'action' => $this->generateUrl('backend_gallery_create', array('type'=> 'photos')),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'backend.create'));

        return $form;
    }

    /**
     * @param Gallery $entity
     * @return \Symfony\Component\Form\Form
     */
    private function createCreateVideoForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryVideoType(), $entity, array(
            'action' => $this->generateUrl('backend_gallery_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'backend.create'));

        return $form;
    }

    /**
     * Displays a form to create a new Gallery entity.
     *
     */
    public function newAction($type)
    {
        $entity = new Gallery();

        if ("photos" == $type) {
            $form = $this->createCreatePhotosForm($entity);
            $template = 'SiteMainBundle:Backend/Gallery:new_photos.html.twig';
        } elseif ("video" == $type) {
            $form = $this->createCreateVideoForm($entity);
            $template = 'SiteMainBundle:Backend/Gallery:new_video.html.twig';
        }

        return $this->render($template, array(
            'entity' => $entity,
            'form'   => $form->createView()
        ));
    }

    /**
     * Displays a form to edit an existing Gallery entity.
     *
     */
    public function editAction($id, $type)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.gallery.not_found'));
        }

        if ("photos" == $type) {
            $template = 'SiteMainBundle:Backend/Gallery:edit_photos.html.twig';
            $editForm = $this->createEditPhotosForm($entity);
        } elseif ("video" == $type) {
            $template = 'SiteMainBundle:Backend/Gallery:edit_video.html.twig';
            $editForm = $this->createEditVideoForm($entity);
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render($template, array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Gallery entity.
    *
    * @param Gallery $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditPhotosForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryPhotosType(), $entity, array(
            'action' => $this->generateUrl('backend_gallery_update', array('id' => $entity->getId(), 'type' => "photos")),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'backend.update'));

        return $form;
    }

    /**
     * Creates a form to edit a Gallery entity.
     *
     * @param Gallery $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditVideoForm(Gallery $entity)
    {
        $form = $this->createForm(new GalleryVideoType(), $entity, array(
            'action' => $this->generateUrl('backend_gallery_update', array('id' => $entity->getId(), 'type' => 'video')),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'backend.update'));

        return $form;
    }

    /**
     * Edits an existing Gallery entity.
     *
     */
    public function updateAction(Request $request, $id, $type)
    {

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SiteMainBundle:Gallery')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException($this->get('translator')->trans('backend.gallery.not_found'));
        }

        $deleteForm = $this->createDeleteForm($id);

        if ("photos" == $type) {
            $editForm = $this->createEditPhotosForm($entity);
            $template = 'SiteMainBundle:Backend/Gallery:edit_photos.html.twig';
        } elseif ("video" == $type) {
            $editForm = $this->createEditVideoForm($entity);
            $template = 'SiteMainBundle:Backend/Gallery:edit_video.html.twig';
        }

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {

            if ("photos" == $type) {
//              Добавляем фотки в фотогалерею
                $imagesJson = $request->get('gallery');
                if ($imagesJson) {

                    $images = json_decode($imagesJson);

                    foreach ($images as $image) {
                        $galleryElementPhoto = new GalleryElementPhoto();
                        $galleryElementPhoto->setLink("uploads/media/" . $image);
                        $galleryElementPhoto->setGallery($entity);
                        $em->persist($galleryElementPhoto);
                    }

                }

//              Удаляем фотки из галереи, отмеченные на удаление
                $galleryElementPhotos = $request->get('photos');

                if(is_array($galleryElementPhotos)){
                    foreach($galleryElementPhotos as $galleryElementPhoto){
                        $repository_gallery_photo = $this->getDoctrine()->getRepository('SiteMainBundle:GalleryElementPhoto');
                        $galleryElementPhotoObject = $repository_gallery_photo->find($galleryElementPhoto);

                        if($galleryElementPhotoObject){
                            if (file_exists($galleryElementPhotoObject->getLink())) {
                                unlink($galleryElementPhotoObject->getLink());
                            }
                            $em->remove($galleryElementPhotoObject);
                        }
                    }
                }

//              Изменение описания фотографий
                $galleryElementPhotosDescription = $request->get('description');

                if(is_array($galleryElementPhotosDescription)){
                    foreach($galleryElementPhotosDescription as $idPhoto => $galleryElementPhotoDescription){
                        $repository_gallery_photo = $this->getDoctrine()->getRepository('SiteMainBundle:GalleryElementPhoto');
                        $galleryElementPhotoObject = $repository_gallery_photo->find($idPhoto);

                        $galleryElementPhotoObject->setDescription($galleryElementPhotoDescription);
                    }
                }

            } elseif ("video" == $type) {
                $editForm = $this->createEditVideoForm($entity);
            }

////          Удаляем видео из галереи, отмеченные на удаление
//            $galleryElementVideos = $request->get('videos');
//
//            if(is_array($galleryElementVideos)){
//                foreach($galleryElementVideos as $galleryElementVideo){
//                    $repository_gallery_video = $this->getDoctrine()->getRepository('SiteMainBundle:GalleryElementVideo');
//                    $galleryElementVideoObject = $repository_gallery_video->find($galleryElementVideo);
//
//                    if($galleryElementVideoObject){
//                        unlink($galleryElementVideoObject->getLink());
//                        $em->remove($galleryElementVideoObject);
//                    }
//                }
//            }

            $em->flush();

            die($id); 

            return $this->redirect($this->generateUrl('backend_gallery_edit', array('id' => $id, 'type' => $type)));
        }

        return $this->render($template, array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Gallery entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SiteMainBundle:Gallery')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException($this->get('translator')->trans('backend.gallery.not_found'));
            }

//            $entity->deleteAllPhotos();

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('backend_gallery_index'));
    }

    /**
     * Creates a form to delete a Gallery entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('backend_gallery_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array(
                'label' => 'backend.delete',
                'translation_domain' => 'menu',
                'attr' => array(
                    'class' => 'btn-danger'
                )
            ))
            ->getForm()
        ;
    }
}
