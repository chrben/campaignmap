<?php

use Illuminate\Database\Seeder;
use App\Calendar;

class CalendarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Forgotten Realms
        $cal = new Calendar();
        $cal->name = 'Forgotten Realms (Calendar of Harptos)';
        $cal->year_length = 365;
        $cal->save();
        $cal->refresh();
        
        $cal->segments()->create([
            'name' => 'Hammer',
            'alt_name' => 'Deepwinter',
            'length' => 30,
            'index' => 0,
        ]);
        $cal->segments()->create([
            'name' => 'Midwinter',
            'length' => 1,
            'index' => 1,
            'is_holiday' => true,
        ]);
        $cal->segments()->create([
            'name' => 'Alturiak',
            'alt_name' => 'The Claw of Winter',
            'length' => 30,
            'index' => 2,
        ]);
        $cal->segments()->create([
            'name' => 'Ches',
            'alt_name' => 'The Claw of Sunsets',
            'length' => 30,
            'index' => 3,
        ]);
        $cal->segments()->create([
            'name' => 'Tarsakh',
            'alt_name' => 'The Claw of Storms',
            'length' => 30,
            'index' => 4,
        ]);
        $cal->segments()->create([
            'name' => 'Greengrass',
            'length' => 1,
            'index' => 5,
            'is_holiday' => true,
        ]);
        $cal->segments()->create([
            'name' => 'Mirtul',
            'alt_name' => 'The Melting',
            'length' => 30,
            'index' => 6,
        ]);
        $cal->segments()->create([
            'name' => 'Kythorn',
            'alt_name' => 'The Time of Flowers',
            'length' => 30,
            'index' => 7,
        ]);
        $cal->segments()->create([
            'name' => 'Flamerule',
            'alt_name' => 'Summertide',
            'length' => 30,
            'index' => 8,
        ]);
        $cal->segments()->create([
            'name' => 'Midsummer',
            'length' => 1,
            'index' => 9,
            'is_holiday' => true,
        ]);
        $cal->segments()->create([
            'name' => 'Shieldmeet',
            'length' => 1,
            'index' => 10,
            'is_holiday' => true,
            'every_nth' => 4,
        ]);
        $cal->segments()->create([
            'name' => 'Eleasis',
            'alt_name' => 'Highsun',
            'length' => 30,
            'index' => 11,
        ]);
        $cal->segments()->create([
            'name' => 'Eleint',
            'alt_name' => 'The Fading',
            'length' => 30,
            'index' => 12,
        ]);
        $cal->segments()->create([
            'name' => 'Highharvestide',
            'length' => 1,
            'index' => 13,
            'is_holiday' => true,
        ]);
        $cal->segments()->create([
            'name' => 'Marpenoth',
            'alt_name' => 'Leaffall',
            'length' => 30,
            'index' => 14,
        ]);
        $cal->segments()->create([
            'name' => 'Uktar',
            'alt_name' => 'The Rotting',
            'length' => 30,
            'index' => 15,
        ]);
        $cal->segments()->create([
            'name' => 'Feast of the Moon',
            'length' => 1,
            'index' => 16,
            'is_holiday' => true,
        ]);
        $cal->segments()->create([
            'name' => 'Nightal',
            'alt_name' => 'The Drawing Down',
            'length' => 30,
            'index' => 17,
        ]);
    }
}
