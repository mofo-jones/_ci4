<?php

namespace App\Controllers;

use CodeIgniter\Autoloader\FileLocator;
use CodeIgniter\Controller;
use CodeIgniter\Hooks\Hooks;

class Test { //extends Controller {

    protected $helpers = ['url'];

    public function index() {
        var_dump(codeigniter()->config->baseURL);

        if ($this->request->getMethod() === 'post') {
            $file = $this->request->getFile('avatar');

            if ($file->isValid() && !$file->hasMoved()) {

                $fileName = $file->getRandomName();
                $file->move(WRITEPATH . 'uploads', $fileName);
            }
        }

        echo view('form');
    }

    //--------------------------------------------------------------------

    public function hooks() {
        Hooks::trigger('myhook');
    }

    //--------------------------------------------------------------------

    public function twodbs() {
        $db1 = \Config\Database::connect('default');
        $db2 = \Config\Database::connect('tests');

        echo view('form');

//		d($db1->listTables());
//		d($db2->listTables());
    }

    //--------------------------------------------------------------------

    public function vfs() {
        return view('form');
    }

    //--------------------------------------------------------------------

    public function locate() {
        $locator = service('locator');

        $routes = $locator->search('Config/Routes');
    }

    public function mail() {

        // Este sempre deverá existir para garantir a exibição correta dos caracteres
        $headers = "MIME-Version: 1.1\n";

// Para enviar o e-mail em formato texto com codificação de caracteres Europeu Ocidental (usado no Brasil)
        $headers .= "Content-type: text/plain; charset=iso-8859-1\n";

// Para enviar o e-mail em formato HTML com codificação de caracteres Europeu Ocidental (usado no Brasil)
        $headers .= "Content-type: text/html; charset=iso-8859-1\n";

// Para enviar o e-mail em formato HTML com codificação de caracteres Unicode (Usado em todos os países)
        $headers .= "Content-type: text/html; charset=utf-8\n";

// E-mail que receberá a resposta quando se clicar no 'Responder' de seu leitor de e-mails
        $headers .= "Reply-To: e-mailDeQuemPreencheuSeuFormulario@dominio.com\n";

// para enviar a mensagem em prioridade máxima
        $headers .= "X-Priority: 1\n";

// para enviar a mensagem em prioridade mínima
        $headers .= "X-Priority: 5\n";

// para enviar a mensagem em prioridade normal (valor padrão caso não seja especificada)
        $headers .= "X-Priority: 3\n";

        // O remetente deve ser um e-mail do seu domínio conforme determina a RFC 822.
        // O return-path deve ser ser o mesmo e-mail do remetente.
        $headers = "MIME-Version: 1.1\r\n";
        $headers .= "Content-type: text/plain; charset=UTF-8\r\n";
        $headers .= "From: eu@seudominio.com\r\n"; // remetente
        $headers .= "Return-Path: eu@seudominio.com\r\n"; // return-path
        $envio = mail("destinatario@algum-email.com", "Assunto", "Texto", $headers);

        if ($envio) {
            echo "Mensagem enviada com sucesso";
        } else {
            echo "A mensagem não pode ser enviada";
        }
    }

}
