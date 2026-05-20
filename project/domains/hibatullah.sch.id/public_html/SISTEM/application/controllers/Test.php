<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Test extends CI_Controller
{
    function jadwal()
    {
        // Data kelas, guru, mata pelajaran, dll. dari database
        $classes = ['ClassA', 'ClassB', 'ClassC'];
        $teachers = ['Teacher1', 'Teacher2', 'Teacher3'];
        $subjects = ['Subject1', 'Subject2', 'Subject3'];
        $rooms = ['Room1', 'Room2', 'Room3'];
        $days = ['Monday', 'Tuesday', 'Wednesday'];
        $periods = ['Period1', 'Period2', 'Period3'];

        // Jumlah jam mata pelajaran yang diperbolehkan setiap guru
        $subjectHours = [
            'Teacher1' => ['Subject1' => 2, 'Subject2' => 3, 'Subject3' => 2],
            'Teacher2' => ['Subject1' => 2, 'Subject2' => 2, 'Subject3' => 3],
            'Teacher3' => ['Subject1' => 3, 'Subject2' => 2, 'Subject3' => 2],
        ];

        // Generate jadwal
        $schedule = $this->generateSchedule($classes, $teachers, $subjects, $rooms, $days, $periods, $subjectHours);

        // Tampilkan hasil
        echo '<pre>';
        print_r($schedule);
        echo '</pre>';
    }

    // Fungsi untuk melakukan penjadwalan
    function generateSchedule($classes, $teachers, $subjects, $rooms, $days, $periods, $subjectHours)
    {
        $schedule = [];

        // Inisialisasi jadwal kosong
        foreach ($teachers as $teacher) {
            $schedule[$teacher] = [];
            foreach ($days as $day) {
                $schedule[$teacher][$day] = [];
                foreach ($periods as $period) {
                    $schedule[$teacher][$day][$period] = [
                        'class' => '',
                        'subject' => '',
                        'room' => ''
                    ];
                }
            }
        }

        // Loop melalui setiap guru dan waktu untuk menempatkan mata pelajaran
        foreach ($teachers as $teacher) {
            foreach ($days as $day) {
                foreach ($periods as $period) {
                    // Temukan mata pelajaran yang belum dijadwalkan untuk guru ini
                    $unassignedSubjects = array_diff($subjects, array_column($schedule[$teacher][$day], 'subject'));

                    if (!empty($unassignedSubjects)) {
                        // Pilih mata pelajaran yang belum mencapai batas jumlah jam
                        foreach ($unassignedSubjects as $subject) {
                            if (!isset($subjectHours[$teacher][$subject]) || $subjectHours[$teacher][$subject] > 0) {
                                // Temukan kelas yang belum dijadwalkan untuk mata pelajaran ini pada waktu tertentu
                                $unassignedClasses = array_diff($classes, array_column($schedule[$teacher][$day], 'class', $subject));

                                if (!empty($unassignedClasses)) {
                                    // Pilih kelas dan ruang yang belum dijadwalkan
                                    $selectedClass = array_rand($unassignedClasses);
                                    $selectedRoom = array_rand($rooms);

                                    // Isi jadwal dengan mata pelajaran yang dipilih
                                    $schedule[$teacher][$day][$period] = [
                                        'class' => $selectedClass,
                                        'subject' => $subject,
                                        'room' => $selectedRoom
                                    ];

                                    // Kurangi jumlah jam mata pelajaran yang tersisa
                                    if (isset($subjectHours[$teacher][$subject])) {
                                        $subjectHours[$teacher][$subject]--;
                                    }

                                    break;
                                }
                            }
                        }
                    }
                }
            }
        }

        return $schedule;
    }
}
