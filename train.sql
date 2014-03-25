--
-- Database: `train`
--

-- --------------------------------------------------------

--
-- Table structure for table `timetable`
--

CREATE TABLE IF NOT EXISTS `timetable` (
  `train_line` varchar(256) NOT NULL,
  `route` varchar(256) NOT NULL,
  `run_number` varchar(256) NOT NULL,
  `operator_id` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;