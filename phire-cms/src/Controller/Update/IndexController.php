<?php

namespace Phire\Controller\Update;

use Pop\Archive\Archive;
use Pop\Http\Client\Curl;
use Phire\Controller\AbstractController;
use Phire\Form;

class IndexController extends AbstractController
{

    /**
     * Update URL
     * @var string
     */
    protected $url = 'http://updates.phirecms.org/releases/phire/phirecms.zip';

    /**
     * Index action method
     *
     * @return void
     */
    public function index()
    {
        // Switch this to < for validation when live
        if (version_compare(\Phire\Module::VERSION, $this->sess->updates->phirecms) >= 0) {
            if ($this->request->getQuery('update') == 1) {
                file_put_contents(__DIR__ . '/../../../../phirecms.zip', fopen($this->url, 'r'));
                $basePath = realpath(__DIR__ . '/../../../../');
                $archive  = new Archive($basePath . '/phirecms.zip');
                $archive->extract($basePath);
                unlink(__DIR__ . '/../../../../phirecms.zip');
                echo 'Done!';
            } else {
                $this->prepareView('phire/update.phtml');
                $this->view->title = 'Update Phire';
                $this->view->url   = $this->url;
                $this->view->phire_update_version = $this->sess->updates->phirecms;
                if (is_writable(__DIR__ . '/../../../../')) {
                    $this->view->form = false;
                } else {
                    $fields = $this->application->config()['forms']['Phire\Form\Update'];
                    $fields[1]['resource']['value'] = 'phirecms';
                    $this->view->form = new Form\Update($fields);
                }

                if (($this->view->form !== false) && ($this->request->isPost())) {
                    $this->view->form->addFilter('strip_tags')
                        ->setFieldValues($this->request->getPost());

                    if ($this->view->form->isValid()) {
                        $fields = $this->view->form->getFields();
                        $curl = new Curl('http://updates.phirecms.org/fetch/' . $fields['resource']);
                        $curl->setFields($fields);
                        $curl->setPost(true);

                        $curl->send();
                        $json = json_decode($curl->getBody(), true);
                        if ($curl->getCode() == 401) {
                            $this->view->form = '<h4 class="error">' . $json['error'] . '</h4>';
                        } else {
                            $basePath = realpath(__DIR__ . '/../../../..' . CONTENT_PATH);
                            $archive  = new Archive($basePath . '/phirecms.zip');
                            $archive->extract($basePath);
                            chmod($basePath . '/phire-cms-new', 0777);
                            unlink(__DIR__ . '/../../../..' . CONTENT_PATH . '/phirecms.zip');

                            $curl = new Curl('http://updates.phirecms.org/fetch/' . $fields['resource'] . '?move=1');
                            $curl->setFields($fields);
                            $curl->setPost(true);

                            $curl->send();
                            $json = json_decode($curl->getBody(), true);
                            if ($curl->getCode() == 401) {
                                $this->view->form = '<h4 class="error">' . $json['error'] . '</h4>';
                            } else {
                                $this->view->form = '<h4 class="required">' . $json['message'] . '</h4>';
                            }
                        }
                    }
                }

                $this->send();
            }
        } else {
            $this->redirect(BASE_PATH . APP_URI);
        }
    }

    /**
     * Run system updater action method
     *
     * @return void
     */
    public function run()
    {

    }

}