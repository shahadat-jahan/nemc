<?php

use Illuminate\Database\Seeder;

class HolidaysTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('holidays')->delete();
        
        \DB::table('holidays')->insert(array (
            0 => 
            array (
                'id' => 1,
                'title' => 'May Day',
                'from_date' => '2019-05-01',
                'to_date' => '2019-05-01',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:37:18',
                'updated_at' => '2019-05-25 09:37:18',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'title' => 'Shab-e-Qadar',
                'from_date' => '2019-06-02',
                'to_date' => '2019-06-02',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2019-05-25 09:38:20',
                'updated_at' => '2019-05-29 10:37:12',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'title' => 'Eid-ul-Fitr',
                'from_date' => '2019-05-05',
                'to_date' => '2019-05-07',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:39:26',
                'updated_at' => '2019-05-25 09:39:26',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'title' => 'Ashura',
                'from_date' => '2019-09-10',
                'to_date' => '2019-09-10',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:40:33',
                'updated_at' => '2019-05-25 09:40:33',
                'deleted_at' => NULL,
            ),
            4 => 
            array (
                'id' => 5,
                'title' => 'Eid-e-Milad-un-Nabi',
                'from_date' => '2019-11-10',
                'to_date' => '2019-11-10',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:46:52',
                'updated_at' => '2019-05-25 09:46:52',
                'deleted_at' => NULL,
            ),
            5 => 
            array (
                'id' => 6,
                'title' => 'Eid-ul-Azha',
                'from_date' => '2019-08-08',
                'to_date' => '2019-08-14',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 1,
                'created_at' => '2019-05-25 09:47:32',
                'updated_at' => '2019-05-28 10:16:05',
                'deleted_at' => NULL,
            ),
            6 => 
            array (
                'id' => 7,
                'title' => 'Bengali New Year',
                'from_date' => '2019-04-14',
                'to_date' => '2019-04-14',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:47:59',
                'updated_at' => '2019-05-25 09:47:59',
                'deleted_at' => NULL,
            ),
            7 => 
            array (
                'id' => 8,
                'title' => 'National Mourning Day',
                'from_date' => '2019-08-15',
                'to_date' => '2019-08-15',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:48:50',
                'updated_at' => '2019-05-25 09:48:50',
                'deleted_at' => NULL,
            ),
            8 => 
            array (
                'id' => 9,
                'title' => 'Victory Day',
                'from_date' => '2019-12-16',
                'to_date' => '2019-12-16',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:49:45',
                'updated_at' => '2019-05-25 09:49:45',
                'deleted_at' => NULL,
            ),
            9 => 
            array (
                'id' => 10,
                'title' => 'Birthday of Sheikh Mujibur Rahman',
                'from_date' => '2019-03-17',
                'to_date' => '2019-03-17',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:50:11',
                'updated_at' => '2019-05-25 09:50:11',
                'deleted_at' => NULL,
            ),
            10 => 
            array (
                'id' => 11,
                'title' => 'Buddha Purnima',
                'from_date' => '2019-05-18',
                'to_date' => '2019-05-18',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:50:41',
                'updated_at' => '2019-05-25 09:50:41',
                'deleted_at' => NULL,
            ),
            11 => 
            array (
                'id' => 12,
                'title' => 'International Mother Language Day',
                'from_date' => '2019-02-21',
                'to_date' => '2019-02-21',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:51:30',
                'updated_at' => '2019-05-25 09:51:30',
                'deleted_at' => NULL,
            ),
            12 => 
            array (
                'id' => 13,
                'title' => 'Shab-e-Barat',
                'from_date' => '2019-04-22',
                'to_date' => '2019-04-22',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:51:57',
                'updated_at' => '2019-05-25 09:51:57',
                'deleted_at' => NULL,
            ),
            13 => 
            array (
                'id' => 14,
                'title' => 'Janmashtami',
                'from_date' => '2019-08-24',
                'to_date' => '2019-08-24',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:53:54',
                'updated_at' => '2019-05-25 09:53:54',
                'deleted_at' => NULL,
            ),
            14 => 
            array (
                'id' => 15,
                'title' => 'Christmas Day',
                'from_date' => '2019-12-25',
                'to_date' => '2019-12-25',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 09:55:11',
                'updated_at' => '2019-05-25 09:55:11',
                'deleted_at' => NULL,
            ),
            15 => 
            array (
                'id' => 16,
                'title' => 'Independence Day',
                'from_date' => '2019-03-26',
                'to_date' => '2019-03-26',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 10:02:00',
                'updated_at' => '2019-05-25 10:02:00',
                'deleted_at' => NULL,
            ),
            16 => 
            array (
                'id' => 17,
                'title' => 'Jumatul Bidah',
                'from_date' => '2019-05-31',
                'to_date' => '2019-05-31',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-25 10:02:49',
                'updated_at' => '2019-05-25 10:02:49',
                'deleted_at' => NULL,
            ),
            17 => 
            array (
                'id' => 18,
                'title' => 'Summer Vacation',
                'from_date' => '2019-05-22',
                'to_date' => '2019-05-28',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-27 12:47:13',
                'updated_at' => '2019-05-27 12:47:13',
                'deleted_at' => NULL,
            ),
            18 => 
            array (
                'id' => 19,
                'title' => 'Durga Puja',
                'from_date' => '2019-10-05',
                'to_date' => '2019-10-08',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => NULL,
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-05-27 12:54:17',
                'updated_at' => '2019-05-27 12:54:17',
                'deleted_at' => NULL,
            ),
            19 => 
            array (
                'id' => 20,
                'title' => 'Saraswati Puja',
                'from_date' => '2020-01-29',
                'to_date' => '2020-01-29',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => '<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" style="border: none;">
<tbody><tr>
<td width="157" valign="top" style="width:117.9pt;border:solid white 1.0pt;
background:#CDDDAC;padding:0in 5.4pt 0in 5.4pt">
<p class="MsoNormal"><strong><span style="font-size: 11pt; font-family: &quot;Arial Unicode MS&quot;, sans-serif;">Optional Holiday</span></strong><span style="font-size:11.0pt;
font-family:&quot;Arial Unicode MS&quot;,&quot;sans-serif&quot;"><o:p></o:p></span></p>
</td>
</tr>
</tbody></table>',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-05 10:32:52',
                'updated_at' => '2019-10-05 10:32:52',
                'deleted_at' => NULL,
            ),
            20 => 
            array (
                'id' => 21,
                'title' => 'International Mother Language Day',
                'from_date' => '2020-02-21',
                'to_date' => '2020-02-21',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => '<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" style="border: none;">
<tbody><tr>
<td width="157" valign="top" style="width:117.9pt;border:solid white 1.0pt;
background:#E6EED5;padding:0in 5.4pt 0in 5.4pt">
<p class="MsoNormal"><strong><span style="font-size: 11pt; font-family: &quot;Arial Unicode MS&quot;, sans-serif;">Public Holiday</span></strong><span style="font-size:11.0pt;
font-family:&quot;Arial Unicode MS&quot;,&quot;sans-serif&quot;"><o:p></o:p></span></p>
</td>
</tr>
</tbody></table>',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-05 10:33:45',
                'updated_at' => '2019-10-05 10:33:45',
                'deleted_at' => NULL,
            ),
            21 => 
            array (
                'id' => 22,
                'title' => 'Sheikh Mujibur Rahman’s birthday',
                'from_date' => '2020-03-17',
                'to_date' => '2020-03-17',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => '<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" style="border: none;">
<tbody><tr>
<td width="157" valign="top" style="width:117.9pt;border:solid white 1.0pt;
background:#CDDDAC;padding:0in 5.4pt 0in 5.4pt">
<p class="MsoNormal"><strong><span style="font-size: 11pt; font-family: &quot;Arial Unicode MS&quot;, sans-serif;">Public Holiday<o:p></o:p></span></strong></p>
</td>
</tr>
</tbody></table>',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-05 10:34:39',
                'updated_at' => '2019-10-05 10:34:39',
                'deleted_at' => NULL,
            ),
            22 => 
            array (
                'id' => 23,
                'title' => 'Independence Day',
                'from_date' => '2020-03-26',
                'to_date' => '2020-03-26',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => '<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" style="border: none;">
<tbody><tr>
<td width="157" valign="top" style="width:117.9pt;border:solid white 1.0pt;
background:#E6EED5;padding:0in 5.4pt 0in 5.4pt">
<p class="MsoNormal"><strong><span style="font-size: 11pt; font-family: &quot;Arial Unicode MS&quot;, sans-serif;">Public Holiday<o:p></o:p></span></strong></p>
</td>
</tr>
</tbody></table>',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-05 10:36:13',
                'updated_at' => '2019-10-05 10:36:13',
                'deleted_at' => NULL,
            ),
            23 => 
            array (
                'id' => 24,
                'title' => 'Shab-e-Barat',
                'from_date' => '2020-04-08',
                'to_date' => '2020-04-08',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => '<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" style="border: none;">
<tbody><tr>
<td width="157" valign="top" style="width:117.9pt;border:solid white 1.0pt;
background:#CDDDAC;padding:0in 5.4pt 0in 5.4pt">
<p class="MsoNormal"><strong><span style="font-size: 11pt; font-family: &quot;Arial Unicode MS&quot;, sans-serif;">Public Holiday<o:p></o:p></span></strong></p>
</td>
</tr>
</tbody></table>',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-05 10:37:08',
                'updated_at' => '2019-10-05 10:37:08',
                'deleted_at' => NULL,
            ),
            24 => 
            array (
                'id' => 25,
                'title' => 'Bengali New Year',
                'from_date' => '2020-04-14',
                'to_date' => '2020-04-14',
                'session_id' => NULL,
                'batch_type_id' => NULL,
                'description' => '<table class="MsoNormalTable" border="1" cellspacing="0" cellpadding="0" style="border: none;">
<tbody><tr>
<td width="157" valign="top" style="width:117.9pt;border:solid white 1.0pt;
background:#E6EED5;padding:0in 5.4pt 0in 5.4pt">
<p class="MsoNormal"><strong><span style="font-size: 11pt; font-family: &quot;Arial Unicode MS&quot;, sans-serif;">Public Holiday<o:p></o:p></span></strong></p>
</td>
</tr>
</tbody></table>',
                'status' => 1,
                'created_by' => 1,
                'updated_by' => 0,
                'created_at' => '2019-10-05 10:37:48',
                'updated_at' => '2019-10-05 10:37:48',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}