<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UserGroupsTableSeeder::class);
        $this->call(UserGroupPermissionsTableSeeder::class);
        $this->call(DepartmentsTableSeeder::class);
        $this->call(DesignationsTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(BatchTypesTableSeeder::class);
        $this->call(ClassTypesTableSeeder::class);
        $this->call(CoursesTableSeeder::class);
        $this->call(EducationBoardsTableSeeder::class);
        $this->call(ExamCategoriesTableSeeder::class);
        $this->call(ExamTypesTableSeeder::class);
        $this->call(ExamSubTypesTableSeeder::class);
        $this->call(PhasesTableSeeder::class);
        $this->call(TermsTableSeeder::class);
        $this->call(ApplicationSettingsTableSeeder::class);
        $this->call(SubjectGroupsTableSeeder::class);
        $this->call(SubjectsTableSeeder::class);
        $this->call(StudentCategoriesTableSeeder::class);
        $this->call(PaymentTypesTableSeeder::class);
        $this->call(AttachmentTypesTableSeeder::class);
        $this->call(SessionsTableSeeder::class);
        $this->call(BanksTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(StudentGroupTypesTableSeeder::class);

/*
        $path = 'database/sql_dumps/';
        DB::unprepared(file_get_contents($path . 'country.sql'));*/

        $this->call(GuardiansTableSeeder::class);
        $this->call(TeachersTableSeeder::class);
        $this->call(HallsTableSeeder::class);
        $this->call(HolidaysTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(AdminUsersTableSeeder::class);
        $this->call(AdmissionParentsTableSeeder::class);
        $this->call(AttachmentTypesTableSeeder::class);
        $this->call(CountriesTableSeeder::class);
        $this->call(AdmissionStudentsTableSeeder::class);
        $this->call(AdmissionAttachmentsTableSeeder::class);
        $this->call(AdmissionEducationHistoriesTableSeeder::class);
        $this->call(AdmissionEmergencyContactsTableSeeder::class);
        //$this->call(ApplicationSettingsTableSeeder::class);
        $this->call(StudentsTableSeeder::class);
        $this->call(AttachmentsTableSeeder::class);
        $this->call(AttencanceTableSeeder::class);
        $this->call(BanksTableSeeder::class);
       //$this->call(BatchTypesTableSeeder::class);
        $this->call(BooksTableSeeder::class);
        $this->call(CardsTableSeeder::class);
        $this->call(CardItemsTableSeeder::class);
        $this->call(TopicHeadsTableSeeder::class);
        $this->call(TopicsTableSeeder::class);
        $this->call(TopicTeachersTableSeeder::class);
        $this->call(ClassRoutinesTableSeeder::class);
        $this->call(ClassRoutineHistoriesTableSeeder::class);
        $this->call(ClassRoutineSessionBatchTypesTableSeeder::class);
        $this->call(StudentGroupsTableSeeder::class);
        $this->call(StudentGroupStudentsTableSeeder::class);
        $this->call(ClassRoutineStudentGroupsTableSeeder::class);
        $this->call(EducationHistoriesTableSeeder::class);
        $this->call(EmergencyContactsTableSeeder::class);
        $this->call(ExamCategoriesTableSeeder::class);
        //still no data start
        $this->call(ExamSubTypesTableSeeder::class);
        $this->call(ExamsTableSeeder::class);
        $this->call(ExamSubjectsTableSeeder::class);
        $this->call(ExamSubjectMarksTableSeeder::class);
        $this->call(ExamSubjectStudentGroupsTableSeeder::class);
        $this->call(ExamResultsTableSeeder::class);
        $this->call(ExamResultHistoriesTableSeeder::class);
        //still no data end
        $this->call(LectureMaterialsTableSeeder::class);
        $this->call(NoticeBoardsTableSeeder::class);
        $this->call(MessagesTableSeeder::class);
        $this->call(MessageRepliesTableSeeder::class);
        $this->call(NotificationsTableSeeder::class);
        $this->call(PasswordResetsTableSeeder::class);
        //$this->call(MigrationsTableSeeder::class);
        $this->call(StudentRollNoTableSeeder::class);
        $this->call(SubjectExamSubTypesTableSeeder::class);
        $this->call(SubjectExamCategoriesTableSeeder::class);
        $this->call(SessionDetailsTableSeeder::class);
        $this->call(SessionPhaseDetailsTableSeeder::class);
        $this->call(SessionPhaseDetailSubjectsTableSeeder::class);
        $this->call(PaymentTypesTableSeeder::class);
        $this->call(PaymentMethodsTableSeeder::class);
        $this->call(PaymentDetailsTableSeeder::class);
        $this->call(StudentFeesTableSeeder::class);
        $this->call(StudentFeeDetailsTableSeeder::class);
        $this->call(StudentPaymentsTableSeeder::class);
        $this->call(StudentPaymentDetailsTableSeeder::class);
        $this->call(PhasePromotionHistoriesTableSeeder::class);
        $this->call(JobsTableSeeder::class);
        $this->call(FailedJobsTableSeeder::class);
        $this->call(CronLogsTableSeeder::class);
        //$this->call(PagesTableSeeder::class);

    }
}
