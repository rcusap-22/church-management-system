<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Member;
use App\Models\Event;
use App\Models\EventBudget;
use App\Models\Tithe;
use App\Models\Attendance;
use App\Models\ChurchBudget;
use App\Models\BudgetBreakdown;

class ChurchSeeder extends Seeder
{
    public function run(): void
    {
        // ==================
        // USERS
        // ==================
        User::firstOrCreate(['email' => 'admin@church.com'], [
            'name'     => 'Admin',
            'password' => Hash::make('admin123'),
            'role'     => 'admin',
        ]);
        User::firstOrCreate(['email' => 'staff@church.com'], [
            'name'     => 'Staff User',
            'password' => Hash::make('staff123'),
            'role'     => 'staff',
        ]);

        // ==================
        // MEMBERS
        // ==================
        $members = [
            ['first_name' => 'Juan',       'last_name' => 'dela Cruz',    'email' => 'juan@email.com',      'phone' => '09171234567', 'address' => 'Matina, Davao City',         'birthdate' => '1985-03-12', 'status' => 'active'],
            ['first_name' => 'Maria',      'last_name' => 'Santos',       'email' => 'maria@email.com',     'phone' => '09181234567', 'address' => 'Buhangin, Davao City',       'birthdate' => '1990-07-22', 'status' => 'active'],
            ['first_name' => 'Roberto',    'last_name' => 'Reyes',        'email' => 'roberto@email.com',   'phone' => '09191234567', 'address' => 'Toril, Davao City',          'birthdate' => '1978-11-05', 'status' => 'active'],
            ['first_name' => 'Ana',        'last_name' => 'Garcia',       'email' => 'ana@email.com',       'phone' => '09201234567', 'address' => 'Calinan, Davao City',        'birthdate' => '1995-01-30', 'status' => 'active'],
            ['first_name' => 'Pedro',      'last_name' => 'Villanueva',   'email' => 'pedro@email.com',     'phone' => '09211234567', 'address' => 'Talomo, Davao City',         'birthdate' => '1982-06-18', 'status' => 'active'],
            ['first_name' => 'Lourdes',    'last_name' => 'Fernandez',    'email' => 'lourdes@email.com',   'phone' => '09221234567', 'address' => 'Agdao, Davao City',          'birthdate' => '1988-09-14', 'status' => 'active'],
            ['first_name' => 'Carlos',     'last_name' => 'Mendoza',      'email' => 'carlos@email.com',    'phone' => '09231234567', 'address' => 'Bangkal, Davao City',        'birthdate' => '1975-04-25', 'status' => 'active'],
            ['first_name' => 'Teresa',     'last_name' => 'Ramos',        'email' => 'teresa@email.com',    'phone' => '09241234567', 'address' => 'Panacan, Davao City',        'birthdate' => '1993-12-08', 'status' => 'active'],
            ['first_name' => 'Antonio',    'last_name' => 'Torres',       'email' => 'antonio@email.com',   'phone' => '09251234567', 'address' => 'Mintal, Davao City',         'birthdate' => '1980-02-17', 'status' => 'active'],
            ['first_name' => 'Rosario',    'last_name' => 'Bautista',     'email' => 'rosario@email.com',   'phone' => '09261234567', 'address' => 'Tugbok, Davao City',         'birthdate' => '1997-08-03', 'status' => 'active'],
            ['first_name' => 'Eduardo',    'last_name' => 'Castillo',     'email' => 'eduardo@email.com',   'phone' => '09271234567', 'address' => 'Marilog, Davao City',        'birthdate' => '1970-05-29', 'status' => 'active'],
            ['first_name' => 'Carmela',    'last_name' => 'Flores',       'email' => 'carmela@email.com',   'phone' => '09281234567', 'address' => 'Baguio District, Davao City','birthdate' => '1992-10-11', 'status' => 'active'],
            ['first_name' => 'Manuel',     'last_name' => 'Cruz',         'email' => 'manuel@email.com',    'phone' => '09291234567', 'address' => 'Matina, Davao City',         'birthdate' => '1983-07-07', 'status' => 'active'],
            ['first_name' => 'Gloria',     'last_name' => 'Aquino',       'email' => 'gloria@email.com',    'phone' => '09301234567', 'address' => 'Buhangin, Davao City',       'birthdate' => '1968-03-21', 'status' => 'inactive'],
            ['first_name' => 'Ricardo',    'last_name' => 'Navarro',      'email' => 'ricardo@email.com',   'phone' => '09311234567', 'address' => 'Toril, Davao City',          'birthdate' => '1987-11-15', 'status' => 'active'],
            ['first_name' => 'Josefina',   'last_name' => 'Luna',         'email' => 'josefina@email.com',  'phone' => '09321234567', 'address' => 'Calinan, Davao City',        'birthdate' => '1994-06-09', 'status' => 'active'],
            ['first_name' => 'Francisco',  'last_name' => 'Morales',      'email' => 'francisco@email.com', 'phone' => '09331234567', 'address' => 'Talomo, Davao City',         'birthdate' => '1979-01-26', 'status' => 'active'],
            ['first_name' => 'Concepcion', 'last_name' => 'Herrera',      'email' => 'conce@email.com',     'phone' => '09341234567', 'address' => 'Agdao, Davao City',          'birthdate' => '1991-04-13', 'status' => 'inactive'],
            ['first_name' => 'Alfredo',    'last_name' => 'Pascual',      'email' => 'alfredo@email.com',   'phone' => '09351234567', 'address' => 'Bangkal, Davao City',        'birthdate' => '1976-09-30', 'status' => 'active'],
            ['first_name' => 'Milagros',   'last_name' => 'Soriano',      'email' => 'milagros@email.com',  'phone' => '09361234567', 'address' => 'Panacan, Davao City',        'birthdate' => '1998-12-25', 'status' => 'active'],
        ];

        foreach ($members as $data) {
            Member::firstOrCreate(['email' => $data['email']], $data);
        }

        $allMembers = Member::all();

        // ==================
        // EVENTS
        // ==================
        $events = [
            [
                'title'            => 'Sunday Worship Service',
                'description'      => 'Weekly Sunday worship service with praise, prayer, and sermon.',
                'date'             => '2026-01-05',
                'time'             => '09:00:00',
                'location'         => 'Main Sanctuary, Davao City',
                'budget_allocated' => 3000.00,
                'breakdown'        => [
                    ['category' => 'Sound System',  'amount' => 1000.00, 'notes' => 'PA system rental'],
                    ['category' => 'Decorations',   'amount' => 500.00,  'notes' => 'Flowers and banners'],
                    ['category' => 'Refreshments',  'amount' => 1000.00, 'notes' => 'Post-service snacks'],
                    ['category' => 'Miscellaneous', 'amount' => 500.00,  'notes' => 'Other expenses'],
                ],
            ],
            [
                'title'            => 'Youth Camp 2026',
                'description'      => 'Annual youth camp for spiritual growth and fellowship.',
                'date'             => '2026-02-14',
                'time'             => '07:00:00',
                'location'         => 'UM Matina Gym, Davao City',
                'budget_allocated' => 25000.00,
                'breakdown'        => [
                    ['category' => 'Venue Rental',  'amount' => 8000.00,  'notes' => 'Gym rental for 2 days'],
                    ['category' => 'Food',           'amount' => 10000.00, 'notes' => 'Meals for 3 days'],
                    ['category' => 'Materials',      'amount' => 3000.00,  'notes' => 'Bibles, notebooks, pens'],
                    ['category' => 'Transportation', 'amount' => 2000.00,  'notes' => 'Bus rental'],
                    ['category' => 'Speaker Fee',    'amount' => 2000.00,  'notes' => 'Guest speaker honorarium'],
                ],
            ],
            [
                'title'            => 'Valentine Couples Night',
                'description'      => 'A special evening for married couples in the congregation.',
                'date'             => '2026-02-14',
                'time'             => '18:00:00',
                'location'         => 'Church Fellowship Hall',
                'budget_allocated' => 8000.00,
                'breakdown'        => [
                    ['category' => 'Decorations', 'amount' => 2500.00, 'notes' => 'Romantic setup'],
                    ['category' => 'Food',        'amount' => 4000.00, 'notes' => 'Dinner for couples'],
                    ['category' => 'Music',       'amount' => 1500.00, 'notes' => 'Live acoustic band'],
                ],
            ],
            [
                'title'            => 'Easter Sunday Service',
                'description'      => 'Celebration of the resurrection of Jesus Christ.',
                'date'             => '2026-04-05',
                'time'             => '06:00:00',
                'location'         => 'Main Sanctuary, Davao City',
                'budget_allocated' => 12000.00,
                'breakdown'        => [
                    ['category' => 'Sound & Lights', 'amount' => 3000.00, 'notes' => 'Special lighting setup'],
                    ['category' => 'Decorations',    'amount' => 3000.00, 'notes' => 'Easter themed decor'],
                    ['category' => 'Food',           'amount' => 4000.00, 'notes' => 'Fellowship meal after service'],
                    ['category' => 'Printing',       'amount' => 2000.00, 'notes' => 'Programs and bulletins'],
                ],
            ],
            [
                'title'            => 'Community Outreach Program',
                'description'      => 'Feeding program and medical mission for the community.',
                'date'             => '2026-03-15',
                'time'             => '08:00:00',
                'location'         => 'Brgy. Matina Aplaya, Davao City',
                'budget_allocated' => 20000.00,
                'breakdown'        => [
                    ['category' => 'Food Packs',     'amount' => 10000.00, 'notes' => '200 food packs'],
                    ['category' => 'Medical Supplies','amount' => 5000.00, 'notes' => 'Basic medicines'],
                    ['category' => 'Transportation', 'amount' => 2000.00,  'notes' => 'Volunteer transport'],
                    ['category' => 'Logistics',      'amount' => 3000.00,  'notes' => 'Tables, tents, chairs'],
                ],
            ],
            [
                'title'            => 'Mid-Year Prayer and Fasting',
                'description'      => '3-day corporate prayer and fasting for the congregation.',
                'date'             => '2026-06-10',
                'time'             => '17:00:00',
                'location'         => 'Main Sanctuary, Davao City',
                'budget_allocated' => 5000.00,
                'breakdown'        => [
                    ['category' => 'Sound System',  'amount' => 2000.00, 'notes' => 'Audio setup'],
                    ['category' => 'Printing',      'amount' => 1000.00, 'notes' => 'Prayer guides'],
                    ['category' => 'Miscellaneous', 'amount' => 2000.00, 'notes' => 'Other needs'],
                ],
            ],
            [
                'title'            => 'Christmas Cantata',
                'description'      => 'Annual Christmas musical presentation by the choir.',
                'date'             => '2026-12-20',
                'time'             => '18:00:00',
                'location'         => 'Main Sanctuary, Davao City',
                'budget_allocated' => 15000.00,
                'breakdown'        => [
                    ['category' => 'Costumes',      'amount' => 4000.00, 'notes' => 'Choir costumes'],
                    ['category' => 'Sound & Lights', 'amount' => 5000.00, 'notes' => 'Professional AV setup'],
                    ['category' => 'Decorations',   'amount' => 3000.00, 'notes' => 'Christmas decor'],
                    ['category' => 'Printing',      'amount' => 1000.00, 'notes' => 'Programs'],
                    ['category' => 'Refreshments',  'amount' => 2000.00, 'notes' => 'Post-show reception'],
                ],
            ],
            [
                'title'            => 'Leadership Training Seminar',
                'description'      => 'Training for cell group leaders and ministry heads.',
                'date'             => '2026-05-23',
                'time'             => '08:00:00',
                'location'         => 'Church Conference Room',
                'budget_allocated' => 7000.00,
                'breakdown'        => [
                    ['category' => 'Speaker Fee',  'amount' => 3000.00, 'notes' => 'Resource speaker'],
                    ['category' => 'Materials',    'amount' => 2000.00, 'notes' => 'Workbooks and handouts'],
                    ['category' => 'Food',         'amount' => 2000.00, 'notes' => 'Lunch and snacks'],
                ],
            ],
        ];

        $createdEvents = [];
        foreach ($events as $eventData) {
            $breakdown = $eventData['breakdown'];
            unset($eventData['breakdown']);

            $event = Event::firstOrCreate(
                ['title' => $eventData['title'], 'date' => $eventData['date']],
                $eventData
            );

            if ($event->budgetBreakdown()->count() === 0) {
                foreach ($breakdown as $item) {
                    EventBudget::create(array_merge($item, ['event_id' => $event->id]));
                }
            }

            $createdEvents[] = $event;
        }

        // ==================
        // TITHES
        // ==================
        $tithesData = [
            ['event_title' => 'Sunday Worship Service',    'date' => '2026-01-05', 'tithe' => 8500,  'offering' => 3200, 'donation' => 1000, 'notes' => 'January 1st Sunday'],
            ['event_title' => null,                        'date' => '2026-01-12', 'tithe' => 7800,  'offering' => 2900, 'donation' => 500,  'notes' => 'January 2nd Sunday'],
            ['event_title' => null,                        'date' => '2026-01-19', 'tithe' => 9100,  'offering' => 3500, 'donation' => 800,  'notes' => 'January 3rd Sunday'],
            ['event_title' => null,                        'date' => '2026-01-26', 'tithe' => 8200,  'offering' => 3100, 'donation' => 600,  'notes' => 'January 4th Sunday'],
            ['event_title' => 'Youth Camp 2026',           'date' => '2026-02-14', 'tithe' => 12000, 'offering' => 5000, 'donation' => 3000, 'notes' => 'Youth Camp special collection'],
            ['event_title' => null,                        'date' => '2026-02-02', 'tithe' => 8700,  'offering' => 3300, 'donation' => 700,  'notes' => 'February 1st Sunday'],
            ['event_title' => null,                        'date' => '2026-02-09', 'tithe' => 7500,  'offering' => 2800, 'donation' => 400,  'notes' => 'February 2nd Sunday'],
            ['event_title' => 'Community Outreach Program','date' => '2026-03-15', 'tithe' => 15000, 'offering' => 6000, 'donation' => 5000, 'notes' => 'Outreach special offering'],
            ['event_title' => null,                        'date' => '2026-03-01', 'tithe' => 8900,  'offering' => 3400, 'donation' => 900,  'notes' => 'March 1st Sunday'],
            ['event_title' => null,                        'date' => '2026-03-08', 'tithe' => 9200,  'offering' => 3600, 'donation' => 1100, 'notes' => 'March 2nd Sunday'],
            ['event_title' => 'Easter Sunday Service',     'date' => '2026-04-05', 'tithe' => 18000, 'offering' => 7500, 'donation' => 4000, 'notes' => 'Easter special collection'],
            ['event_title' => null,                        'date' => '2026-04-12', 'tithe' => 8400,  'offering' => 3200, 'donation' => 700,  'notes' => 'April 2nd Sunday'],
            ['event_title' => null,                        'date' => '2026-04-19', 'tithe' => 8600,  'offering' => 3300, 'donation' => 800,  'notes' => 'April 3rd Sunday'],
        ];

        foreach ($tithesData as $data) {
            $eventId = null;
            if ($data['event_title']) {
                $event = Event::where('title', $data['event_title'])->first();
                $eventId = $event ? $event->id : null;
            }

            Tithe::firstOrCreate(
                ['date' => $data['date'], 'notes' => $data['notes']],
                [
                    'event_id'        => $eventId,
                    'tithe_amount'    => $data['tithe'],
                    'offering_amount' => $data['offering'],
                    'donation_amount' => $data['donation'],
                    'notes'           => $data['notes'],
                    'date'            => $data['date'],
                ]
            );
        }

        // ==================
        // ATTENDANCE
        // ==================
        $pastEvents = Event::where('date', '<', now())->get();

        foreach ($pastEvents as $event) {
            if ($event->attendance()->count() > 0) continue;

            foreach ($allMembers as $member) {
                $rand = rand(1, 10);
                $status = $rand <= 7 ? 'present' : ($rand <= 9 ? 'late' : 'absent');

                Attendance::create([
                    'member_id' => $member->id,
                    'event_id'  => $event->id,
                    'status'    => $status,
                ]);
            }
        }

        // ==================
        // CHURCH BUDGET
        // ==================
        $budget = ChurchBudget::firstOrCreate(
            ['year' => 2026],
            [
                'total_budget' => 200000.00,
                'notes'        => 'Annual church budget for 2026 covering all ministries and operations.',
            ]
        );

        if ($budget->breakdown()->count() === 0) {
            $breakdown = [
                ['category' => 'Events & Programs',    'amount' => 80000.00, 'notes' => 'All church events and special programs'],
                ['category' => 'Community Outreach',   'amount' => 30000.00, 'notes' => 'Feeding programs and medical missions'],
                ['category' => 'Church Maintenance',   'amount' => 25000.00, 'notes' => 'Building repairs and upkeep'],
                ['category' => 'Utilities',            'amount' => 20000.00, 'notes' => 'Electricity, water, internet'],
                ['category' => 'Pastoral Support',     'amount' => 25000.00, 'notes' => 'Pastor and staff allowances'],
                ['category' => 'Missions',             'amount' => 15000.00, 'notes' => 'Local and foreign missions support'],
                ['category' => 'Emergency Fund',       'amount' => 5000.00,  'notes' => 'Reserve for unexpected needs'],
            ];

            foreach ($breakdown as $item) {
                BudgetBreakdown::create(array_merge($item, ['church_budget_id' => $budget->id]));
            }
        }
    }
}