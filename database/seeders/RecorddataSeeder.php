<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use App\Models\Recorddata;
use App\Models\HealthRecord;
use App\Models\HealthZone;
use App\Models\HealthZone2;
use App\Models\Disease;
use App\Models\LifestyleHabit;
use App\Models\ElderlyInformation;

class RecorddataSeeder extends Seeder
{
    public function run()
    {
        $fakerTH = Faker::create('th_TH'); 
        $fakerEN = Faker::create('en_US');

        for ($i = 0; $i < 20; $i++) {
            $recorddata = Recorddata::create([
                'id_card' => $fakerEN->numerify('###########'),
                'prefix' => $fakerTH->randomElement(['ด.ช.', 'ด.ญ.', 'นาย', 'นาง', 'นางสาว']),
                'name' => $fakerTH->firstName,
                'surname' => $fakerTH->lastName,
                'housenumber' => $fakerEN->numberBetween(0, 1000),
                'birthdate' => $fakerEN->date(),
                'age' => $fakerEN->numberBetween(0, 100),
                'blood_group' => $fakerEN->randomElement(['A', 'B', 'AB', 'O']),
                'weight' => $fakerEN->numberBetween(30, 100),
                'height' => $fakerEN->numberBetween(140, 200),
                'waistline' => $fakerEN->numberBetween(60, 120),
                'bmi' => $fakerEN->randomFloat(2, 15, 40),
                'phone' => $fakerEN->numerify('0##-###-####'),
                'idline' => $fakerEN->word,
                'user_id' => $fakerEN->numberBetween(8, 77),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            HealthRecord::create([
                'recorddata_id' => $recorddata->id, // ใช้ recorddata_id ที่ได้จากการสร้าง Recorddata
                'sys' => $fakerEN->numberBetween(90, 180), // ค่าความดันเลือด systolic (90-180)
                'dia' => $fakerEN->numberBetween(60, 120), // ค่าความดันเลือด diastolic (60-120)
                'pul' => $fakerEN->numberBetween(60, 100), // ค่าอัตราการเต้นของหัวใจ (pulse) (60-100 bpm)
                'body_temp' => $fakerEN->randomFloat(1, 36.0, 38.5), // อุณหภูมิร่างกาย (36.0 - 38.5 องศาเซลเซียส)
                'blood_oxygen' => $fakerEN->randomFloat(1, 90.0, 100.0), // ระดับออกซิเจนในเลือด (90.0 - 100.0%)
                'blood_level' => $fakerEN->randomFloat(1, 3.5, 6.0), // ระดับน้ำตาลในเลือด (3.5 - 6.0 mmol/L)
            ]);

            HealthZone::create([
                'recorddata_id' => $recorddata->id,
                'zone1_normal' => $fakerEN->boolean,
                'zone1_risk_group' => $fakerEN->boolean,
                'zone1_good_control' => $fakerEN->boolean,
                'zone1_watch_out' => $fakerEN->boolean,
                'zone1_danger' => $fakerEN->boolean,
                'zone1_critical' => $fakerEN->boolean,
                'zone1_complications' => $fakerEN->boolean,
                'zone1_heart' => $fakerEN->boolean,
                'zone1_cerebrovascular' => $fakerEN->boolean,
                'zone1_kidney' => $fakerEN->boolean,
                'zone1_eye' => $fakerEN->boolean,
                'zone1_foot' => $fakerEN->boolean,
            ]);

            HealthZone2::create([
                'recorddata_id' => $recorddata->id,
                'zone2_normal' => $fakerEN->boolean,
                'zone2_risk_group' => $fakerEN->boolean,
                'zone2_good_control' => $fakerEN->boolean,
                'zone2_watch_out' => $fakerEN->boolean,
                'zone2_danger' => $fakerEN->boolean,
                'zone2_critical' => $fakerEN->boolean,
                'zone2_complications' => $fakerEN->boolean,
                'zone2_heart' => $fakerEN->boolean,
                'zone2_eye' => $fakerEN->boolean,
            ]);

            Disease::create([
                'recorddata_id' => $recorddata->id,
                'diabetes' => $fakerEN->boolean,
                'cerebral_artery' => $fakerEN->boolean,
                'kidney' => $fakerEN->boolean,
                'blood_pressure' => $fakerEN->boolean,
                'heart' => $fakerEN->boolean,
                'eye' => $fakerEN->boolean,
                'other' => $fakerEN->boolean,
            ]);

            LifestyleHabit::create([
                'recorddata_id' => $recorddata->id,
                'drink' => $fakerEN->boolean,             // สุ่มค่าจาก true หรือ false
                'drink_sometimes' => $fakerEN->boolean,   // สุ่มค่าจาก true หรือ false
                'dont_drink' => $fakerEN->boolean,        // สุ่มค่าจาก true หรือ false
                'smoke' => $fakerEN->boolean,             // สุ่มค่าจาก true หรือ false
                'sometime_smoke' => $fakerEN->boolean,    // สุ่มค่าจาก true หรือ false
                'dont_smoke' => $fakerEN->boolean,        // สุ่มค่าจาก true หรือ false
                'troubled' => $fakerEN->boolean,          // สุ่มค่าจาก true หรือ false
                'dont_live' => $fakerEN->boolean,         // สุ่มค่าจาก true หรือ false
                'bored' => $fakerEN->boolean, 
            ]);

            ElderlyInformation::create([
                'recorddata_id' => $recorddata->id,
                'help_yourself' => $fakerEN->boolean, // ค่าบูลีน
                'can_help' => $fakerEN->boolean,       // ค่าบูลีน
                'cant_help' => $fakerEN->boolean,      // ค่าบูลีน
                'caregiver' => $fakerEN->boolean,      // ค่าบูลีน
                'have_caregiver' => $fakerEN->boolean, // ค่าบูลีน
                'no_caregiver' => $fakerEN->boolean,   // ค่าบูลีน
                'group1' => $fakerEN->boolean,         // ค่าบูลีน
                'group2' => $fakerEN->boolean,         // ค่าบูลีน
                'group3' => $fakerEN->boolean,         // ค่าบูลีน
                'house' => $fakerEN->boolean,             // คำสุ่ม
                'society' => $fakerEN->boolean,           // คำสุ่ม
                'bed_ridden' => $fakerEN->boolean,     // ค่าบูลีน
            ]);
        }
    }
}
