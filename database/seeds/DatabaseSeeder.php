<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
    }
}

class RolesSeeder extends Seeder
{

    public function run()
    {
        DB::table('roles')->insert([
            ['name' => 'administrator', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>' Administrator'],
            ['name' => 'business_owner', 'guard_name' => 'web', 'type' => 'frontoffice','display_name'=>'Entrepreneur'],
            ['name' => 'fundmanager', 'guard_name' => 'web', 'type' => 'frontoffice','display_name'=>'Fund Manager'],
            ['name' => 'investor', 'guard_name' => 'web', 'type' => 'frontoffice','display_name'=>' Investor'],
            ['name' => 'yet_to_be_approved_investor', 'guard_name' => 'web', 'type' => 'frontoffice','display_name'=>'Yet to be Approved Investor'],
            ['name' => 'yet_to_be_approved_intermediary', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Yet to be Approved Intermediary'],
            ['name' => 'network', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Network'],
            ['name' => 'tier_1_visa_admin', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Tier 1 Visa Admin'],
            ['name' => 'wealth_manager', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Wealth Manager'],
            ['name' => 'introducer', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Introducer'],
            ['name' => 'firm_admin', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Firm Admin'],
            ['name' => 'analyst', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Analyst'],
            ['name' => 'director', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Director'],            
            ['name' => 'family_admin', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Family Admin'],
            ['name' => 'family_head', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>' Administrator'],
            ['name' => 'tier_1_visa_agent', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Family Head'],
            ['name' => 'growthmail', 'guard_name' => 'web', 'type' => 'backoffice','display_name'=>'Growthmail'],
        ]);
    }
}

class CertificationSeeder extends Seeder
{
    public function run()
    {
        DB::table('defaults')->insert([
            ['name' => 'Retail (Restricted) Investor', 'slug' => 'retail_restricted_investor', 'type' => 'certification'],
            ['name' => 'Sophisticated Investor', 'slug' => 'sophisticated_investor', 'type' => 'certification'],
            ['name' => 'High Net Worth Individual', 'slug' => 'high_net_worth_individual', 'type' => 'certification'],
            ['name' => 'Professional Investor', 'slug' => 'professional_investor', 'type' => 'certification'],
            ['name' => 'Advised Investor', 'slug' => 'advised_investor', 'type' => 'certification'],
            ['name' => 'Elective Professional Investor', 'slug' => 'elective_professional_investor', 'type' => 'certification'],
        ]);
    }
}
