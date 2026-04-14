ALTER TABLE `attencance`
ADD UNIQUE INDEX `uniqueStudentandClassroutine` (`student_id`, `class_routine_id`) USING BTREE ;
