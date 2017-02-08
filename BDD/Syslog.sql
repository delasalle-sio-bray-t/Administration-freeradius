-- phpMyAdmin SQL Dump
-- version 4.2.12deb2+deb8u2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Feb 08, 2017 at 09:49 AM
-- Server version: 5.5.53-0+deb8u1
-- PHP Version: 5.6.29-0+deb8u1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `Syslog`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `explode_table`(IN `bound` VARCHAR(255))
BEGIN

    DECLARE id INT DEFAULT 0;
    DECLARE value TEXT;
    DECLARE occurance INT DEFAULT 0;
    DECLARE i INT DEFAULT 0;
    DECLARE splitted_value INT;
    DECLARE done INT DEFAULT 0;
    DECLARE cur1 CURSOR FOR SELECT ID, Message
                                         FROM SystemEvents
                                         WHERE SUBSTRING(Message, 12 , 8) LIKE 'VLAN%';
    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = 1;

    DROP TEMPORARY TABLE IF EXISTS table2;
    CREATE TEMPORARY TABLE table2(
    `id` INT NOT NULL,
    `value` VARCHAR(255) NOT NULL
    ) ENGINE=Memory;

    OPEN cur1;
      read_loop: LOOP
        FETCH cur1 INTO id, value;
        IF done THEN
          LEAVE read_loop;
        END IF;

        SET occurance = (SELECT LENGTH(value)
                                 - LENGTH(REPLACE(value, bound, ''))
                                 +1);
        SET i=1;
        WHILE i <= occurance DO
          SET splitted_value =
          (SELECT REPLACE(SUBSTRING(SUBSTRING_INDEX(value, bound, i),
          LENGTH(SUBSTRING_INDEX(value, bound, i - 1)) + 1), ',', ''));

          INSERT INTO table2 VALUES (id, splitted_value);
          SET i = i + 1;

        END WHILE;
      END LOOP;

      SELECT * FROM table2;
    CLOSE cur1;
  END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `SystemEvents`
--

CREATE TABLE IF NOT EXISTS `SystemEvents` (
`ID` int(10) unsigned NOT NULL,
  `CustomerID` bigint(20) DEFAULT NULL,
  `ReceivedAt` datetime DEFAULT NULL,
  `DeviceReportedTime` datetime DEFAULT NULL,
  `Facility` smallint(6) DEFAULT NULL,
  `Priority` smallint(6) DEFAULT NULL,
  `FromHost` varchar(60) DEFAULT NULL,
  `Message` text,
  `NTSeverity` int(11) DEFAULT NULL,
  `Importance` int(11) DEFAULT NULL,
  `EventSource` varchar(60) DEFAULT NULL,
  `EventUser` varchar(60) DEFAULT NULL,
  `EventCategory` int(11) DEFAULT NULL,
  `EventID` int(11) DEFAULT NULL,
  `EventBinaryData` text,
  `MaxAvailable` int(11) DEFAULT NULL,
  `CurrUsage` int(11) DEFAULT NULL,
  `MinUsage` int(11) DEFAULT NULL,
  `MaxUsage` int(11) DEFAULT NULL,
  `InfoUnitID` int(11) DEFAULT NULL,
  `SysLogTag` varchar(60) DEFAULT NULL,
  `EventLogType` varchar(60) DEFAULT NULL,
  `GenericFileName` varchar(60) DEFAULT NULL,
  `SystemID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Triggers `SystemEvents`
--
DELIMITER //
CREATE TRIGGER `vlan` BEFORE INSERT ON `SystemEvents`
 FOR EACH ROW begin
DECLARE numVlan varchar(5);
DECLARE msg varchar(20);
DECLARE existe int(1);
DECLARE nomVlan varchar(64);

SET msg = SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.Message, ' ', 3), ' ', -1);
-- Si c'est une creation
IF msg = "VLAN" THEN
-- Si le vlan n'existe pas déjà dans la base
SET numVlan = SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.Message, ' ', 4), ' ', -1);
SELECT radius.vlanExist(numVlan) into existe;
if existe = 0 then
INSERT INTO radius.radgroupreply (groupname, attribute, op, value) VALUES
(numVlan, 'Tunnel-Private-Group-Id', '=', numVlan),
(numVlan, 'Tunnel-Type', '=', '13'),
(numVlan, 'Tunnel-Medium-Type', '=', '6');
-- Fin if existe = 0
end if;
-- fin if message = vlan
end if;

if msg = "Deleting" THEN
SET numVlan =  SUBSTRING(SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.Message, ' ', 5), ' ', -1), 1, CHAR_LENGTH(SUBSTRING_INDEX(SUBSTRING_INDEX(NEW.Message, ' ', 5), ' ', -1) ) - 3);
SELECT radius.nomVlan(numVlan) into nomVlan;

Delete from radius.radgroupreply WHERE groupname = nomVlan;
END IF;

end
//
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `SystemEventsProperties`
--

CREATE TABLE IF NOT EXISTS `SystemEventsProperties` (
`ID` int(10) unsigned NOT NULL,
  `SystemEventID` int(11) DEFAULT NULL,
  `ParamName` varchar(255) DEFAULT NULL,
  `ParamValue` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `SystemEvents`
--
ALTER TABLE `SystemEvents`
 ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `SystemEventsProperties`
--
ALTER TABLE `SystemEventsProperties`
 ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `SystemEvents`
--
ALTER TABLE `SystemEvents`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT for table `SystemEventsProperties`
--
ALTER TABLE `SystemEventsProperties`
MODIFY `ID` int(10) unsigned NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
