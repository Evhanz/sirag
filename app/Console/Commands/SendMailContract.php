<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use sirag\Repositories\PersonalRep;

class SendMailContract extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'alert:ContractDefeated';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'envia email de los contrtos por vencer';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //

        $rep = new PersonalRep();

        $contratos = $rep->getContratosPorVencer();

        if(count($contratos) > 0)
        {
            $res['contratos'] = $contratos;


            //se envia el array y la vista lo recibe en llaves individuales {{ $email }} , {{ $subject }}...
            \Mail::send('email', $res, function($message)
            {
                //remitente
                $message->from('sirag@agrograce.com.pe', 'Sistema Sirag');

                //asunto
                $message->subject('Contratos por vencer');

                //receptor
               // $message->to(['atejada@agrograce.com.pe','jmiranda@agrograce.com.pe','yjimenez@agrograce.com.pe']);
                $message->to(['eidelhs@gmail.com','ehernandez@agrograce.com.pe']);

            });


        }

        $this->info('Correcto'.count($contratos));


    }
}
