<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Products;
use App\Mail\ListOfAllProducts;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProductCron extends Command
{
     public $products;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'product:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send email every 10 menits';

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
     * @return int
     */
    public function handle()
    {
        $products = Products::all();
        $user = User::pluck('email');
        
        foreach ($user as $u) {
            Mail::to($u)->send(new ListOfAllProducts($products));
        }
    }
}
