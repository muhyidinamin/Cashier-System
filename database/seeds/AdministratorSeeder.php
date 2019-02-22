<?php

use Illuminate\Database\Seeder;

class AdministratorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $administrator = new \App\User;
        $administrator->username = "administrator";
        $administrator->name = "Site Administrator";
        $administrator->email = "muhyidin@sistem-kasir.test";
        $administrator->roles = json_encode(["ADMIN"]);
        $administrator->password = \Hash::make("admin");
        $administrator->avatar = "saat-ini-tidak-ada-file.png";
        $administrator->phone = "081558805545";
        $administrator->address = "Kedung Banteng RT:013/RW:002, Cabean Kunti, Cepogo, Boyolali";
        $administrator->status = "ACTIVE";
        $administrator->save();
        $this->command->info("User Admin berhasil diinsert");
    }
}
