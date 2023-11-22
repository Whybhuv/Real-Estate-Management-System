--
-- Database: `real_estate`
--
DROP DATABASE IF EXISTS `real_estate`;
CREATE DATABASE IF NOT EXISTS `real_estate` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `real_estate`;

--
-- Table structure for table `state`
--

CREATE TABLE `state` (
  `sid` varchar(3) NOT NULL PRIMARY KEY,
  `sname` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `state`
--

INSERT INTO state (`sid`, `sname`) VALUES
('S01', 'Gujarat'),
('S02', 'Maharashtra'),
('S03', 'Uttar Pradesh'),
('S04', 'Kerala'),
('S05', 'Karnataka'),
('S06', 'Tamil Nadu'),
('S07', 'Uttarakhand'),
('S08', 'Himachal Pradesh'),
('S09', 'Delhi'),
('S10', 'Assam');


--
-- Table structure for table `city`
--

CREATE TABLE `city` (
  `cid` varchar(3) NOT NULL PRIMARY KEY,
  `sid` varchar(3) NOT NULL,
  `cname` varchar(20) NOT NULL,
  FOREIGN KEY(`sid`) references `state`(`sid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `city`
--

INSERT INTO `city` (`cid`, `sid`, `cname`) VALUES
('C01', 'S01', 'Ahmedabad'),
('C02', 'S01', 'Gandhinagar'),
('C03', 'S02', 'Mumbai'),
('C04', 'S02', 'Pune'),
('C05', 'S03', 'Kanpur'),
('C06', 'S05', 'Bangalore'),
('C07', 'S04', 'Kochi'),
('C08', 'S04', 'Thiruvananthapuram'),
('C09', 'S06', 'Chennai'),
('C10', 'S10', 'Dispur');


--
-- Table structure for table `agent`
--

CREATE TABLE `agent` (
  `aid` varchar(3) NOT NULL PRIMARY KEY,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `aemail` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agent`
--

INSERT INTO `agent` (`aid`, `fname`, `lname`, `aemail`) VALUES
('NA', 'NA', 'NA', 'NA@gmail.com'),
('A01', 'Ravi', 'Kumar', 'ravi12kumar@gmail.com'),
('A02', 'Sunil', 'Sharma', 'sunil.sharma@hotmail.com'),
('A03', 'Amit', 'Patel', 'amit_patel1997@gmail.com'),
('A04', 'Priya', 'Singh', 'priya_singh06@gmail.com'),
('A05', 'Vijay', 'Verma', 'vijay.verma@yahoo.com'),
('A06', 'Anjali', 'Rao', 'anjali.rao@gmail.com'),
('A07', 'Rahul', 'Mehta', 'rahul.mehta@hotmail.com'),
('A08', 'Sneha', 'Gupta', 'sneha.gupta@gmail.com'),
('A09', 'Karan', 'Kapoor', 'karan.kapoor@yahoo.com'),
('A10', 'Pooja', 'Rani', 'pooja.rani@hotmail.com');


CREATE TABLE `agent_phone` (
  `phone_id` int AUTO_INCREMENT NOT NULL,
  `aid` varchar(3) NOT NULL,
  `aphone` bigint NOT NULL,
  PRIMARY KEY (`phone_id`),
  FOREIGN KEY (`aid`) REFERENCES `agent` (`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `agent_phone`
--

INSERT INTO `agent_phone` (`aid`, `aphone`) VALUES
('NA', 8123456790),
('A01', 9876543210),
('A01', 8765432109),
('A02', 7654321098),
('A03', 9871234567),
('A03', 8762345671),
('A04', 7653456782),
('A04', 9874567890),
('A05', 4321098765),
('A06', 3210987654),
('A07', 2109876543),
('A08', 1098765432),
('A09', 0987654321),
('A10', 9876543210);


--
-- Table structure for table `role`
--

CREATE TABLE `role` (
  `rtype` varchar(5) NOT NULL PRIMARY KEY,
  `rid` varchar(3) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role`
--

INSERT INTO `role` (`rtype`, `rid`) VALUES
('Admin', 'R01'),
('User', 'R02');


--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `uid` varchar(3) NOT NULL PRIMARY KEY,
  `aid` varchar(3) NOT NULL,
  `rtype` varchar(5) NOT NULL,
  `fname` varchar(20) NOT NULL,
  `lname` varchar(20) NOT NULL,
  `upass` varchar(20) NOT NULL,
  `uemail` varchar(30) NOT NULL,
  FOREIGN KEY(`aid`) references `agent`(`aid`),
  FOREIGN KEY(`rtype`) references `role`(`rtype`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`uid`, `aid`, `rtype`, `fname`, `lname`, `upass`, `uemail`) VALUES
('U01', 'A01', 'User', 'Saurabh', 'Singh', 'password1', 'saurabh.singh@gmail.com'),
('U02', 'A02', 'User', 'Sunita', 'Sharma', 'password2', 'sunita.sharma@gmail.com'),
('U03', 'A03', 'User', 'Amit', 'Kumar', 'password3', 'amit.kumar.patel@gmail.com'),
('U04', 'A04', 'User', 'Pritam', 'Banerjee', 'password4', 'pritam.banerjee@gmail.com'),
('U05', 'A01', 'User', 'Vijay', 'Verma', 'password5', 'vijay.verma@gmail.com'),
('U06', 'A02', 'User', 'Anita', 'Desai', 'password6', 'anita.desai@gmail.com'),
('U07', 'A03', 'User', 'Raj', 'Kapoor', 'password7', 'raj.kapoor@gmail.com'),
('U08', 'A04', 'User', 'Meena', 'Kumari', 'password8', 'meena.kumari@gmail.com'),
('U09', 'A01', 'User', 'Rajesh', 'Khanna', 'password9', 'rajesh.khanna@gmail.com'),
('U10', 'A02', 'User', 'Hema', 'Malini', 'password10', 'hema.malini@gmail.com'),
('U11', 'NA', 'Admin', 'Nitesh', 'Tiwari', 'password11', 'nitesh.tiwari@gmail.com');


--
-- Table structure for table `user_phone`
--

CREATE TABLE `user_phone` (
  `phone_id` int AUTO_INCREMENT NOT NULL PRIMARY KEY,
  `uid` varchar(3) NOT NULL,
  `uphone` bigint NOT NULL,
  FOREIGN KEY (`uid`) REFERENCES `user` (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_phone`
--

INSERT INTO `user_phone` (`uid`, `uphone`) VALUES
('U01', 9876543210),
('U01', 8768901234), 
('U02', 7659012345),
('U02', 8765432109),
('U03', 7654321098),
('U03', 9870123456),
('U04', 9871234567),
('U05', 8762345671),
('U06', 7653456782),
('U07', 9874567890),
('U08', 8765678901),
('U09', 7656789012),
('U10', 9877890123),
('U11', 7589064321);


--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `fid` varchar(3) NOT NULL PRIMARY KEY,
  `uid` varchar(3) NOT NULL,
  `fdescription` varchar(300) NOT NULL,
  `status` int NOT NULL,
  `date` date NOT NULL,
  FOREIGN KEY(`uid`) references `user`(`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`fid`, `uid`, `fdescription`, `status`, `date`) VALUES
('F01', 'U01', 'The website made my life easy. It helped me with the search for my first ever investment i.e. 1BHK apartment in Mira Road. Thanks to the team for providing relevant tools like EMI calculator and smart search.\r\n', 1, '2023-10-20'),
('F02', 'U02', 'I am young professional, the website search helped me in shortlisting property in Navi Mumbai. I learned what kind of property will cost me how much and what are the types of amenities I will be getting?', 1, '2023-10-21'),
('F03', 'U03', 'I was looking for a flat in Andheri and the website helped me get one smoothly. I could choose not just the property but also check what others had to say about the area. The site is simple and user friendly.\r\n', 1, '2023-10-22'),
('F04', 'U09', 'The constant touch through other true calls really surprised me.They sent their officer to get the photographs of my shop & promptly posted all the pics which helped me in getting the tenant fast. Hats off to Magicbricks.\r\n', 1, '2023-10-23'),
('F05', 'U10', 'I moved to Mumbai from Delhi early this year and I looked online for a suitable apartment for rent in areas near my workplace in Andheri. Thanks Magicbricks for giving me so many options with Travel Time search.\r\n', 0, '2023-10-23'),
('F06', 'U06', 'Very Great website for looking at houses in assam particularly in Dispur area in which i got house very fast for sale.\r\n', 1, '2023-10-24'),
('F07', 'U08', 'At first i was having a lot of difficulty in finding potential buyer for my flat in Dispur. But the website helped me find a potential good buyer.\r\n', 1, '2023-10-24'),
('F08', 'U07', 'There are so many options for flats and villas available in this website. Very good to use.\r\n', 0, '2023-10-24'),
('F09', 'U04', 'Today my experience using the site was not like usual. It bad some errors in loading particular properties. Needs to be fixed ASAP.\r\n', 0, '2023-10-25'),
('F10', 'U05', 'Uncharacteristic behavior from the website today unlike usual. It is under maintainance. Will be back operational at full capacity tomorrow.\r\n', 0, '2023-10-25');


--
-- Table structure for table `property`
--

START TRANSACTION;

CREATE TABLE `property` (
  `pid` varchar(4) NOT NULL PRIMARY KEY,
  `cid` varchar(3) NOT NULL,
  `uid` varchar(3) NOT NULL,
  `aid` varchar(3) NOT NULL,
  `title` varchar(30) NOT NULL,
  `description` varchar(100) NOT NULL,
  `bedrooms` int NOT NULL,
  `size` int NOT NULL,
  `type` varchar(10) NOT NULL,
  `price` int NOT NULL,
  FOREIGN KEY(`cid`) references `city`(`cid`),
  FOREIGN KEY(`uid`) references `user`(`uid`),
  FOREIGN KEY(`aid`) references `agent`(`aid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table property
--

INSERT INTO `property` (`pid`, `cid`, `uid`, `aid`, `title`, `description`, `bedrooms`, `size`, `type`, `price`) VALUES
('PR01', 'C01', 'U01', 'A01', 'Luxury Villa', 'A beautiful villa in a serene neighborhood with a spacious garden.', 4, 3500, 'Villa', 7500000),
('PR02', 'C02', 'U02', 'A02', 'Cozy Apartment', 'A cozy apartment in the city center with great views.', 2, 1200, 'Apartment', 5000000),
('PR03', 'C03', 'U03', 'A03', 'Modern Penthouse', 'A modern penthouse apartment with open floor plan and high ceilings.', 3, 3500, 'Penthouse', 6000000),
('PR04', 'C04', 'U04', 'A04', 'Charming Bungalow', 'A charming bungalow with a large backyard.', 3, 2400, 'Bungalow', 6500000),
('PR05', 'C05', 'U03', 'A03', 'Elegant Apartment', 'An elegant apartment in a great complex with top-notch amenities.', 2, 1400, 'Apartment', 7000000),
('PR06', 'C06', 'U06', 'A02', 'Spacious Duplex', 'A spacious duplex with a private garage.', 3, 2800, 'Duplex', 8000000),
('PR07', 'C07', 'U03', 'A03', 'Stylish Apartment', 'A stylish apartment located in a vibrant community.', 4, 3000, 'Apartment', 8500000),
('PR08', 'C08', 'U08', 'A04', 'Classic Cottage' , 'A classic cottage with a welcoming front porch.' , 2, 2000, 'Cottage', 9000000),
('PR09', 'C06', 'U09', 'A01', 'Contemporary Studio' , 'A contemporary studio with a functional layout.' , 1, 1000 , 'Studio', 4500000),
('PR10', 'C06', 'U10', 'A02', 'Rustic Cabin' , 'A rustic cabin with a wood-burning fireplace.' , 3, 2200, 'Cabin', 5500000);

COMMIT;


-- User Registration

DELIMITER //
CREATE TRIGGER AgentIDExistsBeforeRegisterUser
BEFORE INSERT ON `user` FOR EACH ROW
BEGIN
    DECLARE agentCount INT;

    -- Check if the agent with the provided agentID exists
    SELECT COUNT(*) INTO agentCount FROM `agent` WHERE aid = NEW.aid;

    -- If the agent does not exist, prevent user registration
    IF agentCount = 0 THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Agent with the specified agentID does not exist';
    END IF;
END;
//
DELIMITER ;


DELIMITER //
CREATE PROCEDURE RegisterUser(
    IN agentID VARCHAR(3),
    IN UserFname VARCHAR(20),
    IN UserLname VARCHAR(20),
    IN UserPass VARCHAR(20),
    IN UserEmail VARCHAR(30)
)
BEGIN
    -- Calculate the next user ID
    DECLARE newUid VARCHAR(3);
    SET newUid = (SELECT CONCAT('U', LPAD(MAX(CONVERT(SUBSTRING(uid, 2), SIGNED)) + 1, 2, '0')) FROM `user`);
    
    INSERT INTO `user`(uid, aid, rtype, fname, lname, upass, uemail)
    VALUES (newUid, agentID, 'User', UserFname, UserLname, UserPass, UserEmail);
    
    COMMIT;
END;
//
DELIMITER ;


-- Registering an Admin
DELIMITER //
CREATE PROCEDURE RegisterAdmin(
    IN UserFname VARCHAR(20),
    IN UserLname VARCHAR(20),
    IN UserPass VARCHAR(20),
    IN UserEmail VARCHAR(30)
)
BEGIN
    -- Calculate the next user ID
    DECLARE newUid VARCHAR(3);
    SET newUid = (SELECT CONCAT('U', LPAD(MAX(CONVERT(SUBSTRING(uid, 2), SIGNED)) + 1, 2, '0')) FROM `user`);
    
    INSERT INTO `user`(uid, aid, rtype, fname, lname, upass, uemail)
    VALUES (newUid, 'NA', 'Admin', UserFname, UserLname, UserPass, UserEmail);
    
    COMMIT;
END;
//
DELIMITER ;


-- DROP PROCEDURE RegisterUser;

-- User Login

DELIMITER //
CREATE FUNCTION LoginUser(userEmail VARCHAR(30), userPassword VARCHAR(20)) RETURNS VARCHAR(3)
DETERMINISTIC
READS SQL DATA
BEGIN
   DECLARE user_uid VARCHAR(3);
   SELECT uid INTO user_uid FROM `user` WHERE uemail COLLATE utf8mb4_general_ci = userEmail COLLATE utf8mb4_general_ci AND upass = userPassword COLLATE utf8mb4_general_ci;
   RETURN user_uid;
END;
//
DELIMITER ;


-- Property Search

DELIMITER //
CREATE PROCEDURE SearchProperty(IN keyword VARCHAR(100))
BEGIN
   SELECT * FROM property WHERE `description` COLLATE utf8mb4_general_ci LIKE CONCAT('%', keyword, '%') COLLATE utf8mb4_general_ci;
END;
//
DELIMITER ;


-- Giving Feedback 

DELIMITER //
CREATE PROCEDURE InsertFeedback(
    IN userID VARCHAR(3),
    IN fbDescription VARCHAR(300),
    IN fbStatus INT,
    IN fbDate DATE
)
BEGIN
    -- Calculate the next feedback ID
    DECLARE newFid VARCHAR(3);
    SET newFid = (SELECT CONCAT('F', LPAD(MAX(CONVERT(SUBSTRING(fid, 2), SIGNED)) + 1, 2, '0')) FROM `feedback`);
    
    -- Insert the feedback into the feedback table
    INSERT INTO feedback (fid, uid, fdescription, `status`, `date`)
    VALUES (newFid, userID, fbDescription, fbStatus, fbDate);
    
    COMMIT;
END;
//
DELIMITER ;


-- Property Management

DELIMITER //
CREATE PROCEDURE AddProperty(
    IN userID VARCHAR(3),
    IN agentID VARCHAR(3),
    IN cityName VARCHAR(20),
    IN stateName VARCHAR(20),
    IN propTitle VARCHAR(30),
    IN propDescription VARCHAR(100),
    IN propBedrooms INT,
    IN propSize INT,
    IN propType VARCHAR(10),
    IN propPrice INT
)
BEGIN
   -- Generate a new pid based on existing data
   DECLARE newPid VARCHAR(4);

   -- Check if the state with the given name already exists
   SELECT COUNT(*) INTO @stateExists FROM state WHERE sname = stateName COLLATE utf8mb4_general_ci;

   -- If the state doesn't exist, insert it into the state table
   IF @stateExists = 0 THEN
        -- Calculate the next state ID based on existing data
        SET @newStateID = (SELECT CONCAT('S', LPAD(MAX(CONVERT(SUBSTRING(sid, 2), SIGNED)) + 1, 2, '0')) FROM state);

        -- Insert the new state into the state table
        INSERT INTO state (sid, sname) VALUES (@newStateID, stateName);
   END IF;

   -- Check if the city with the given name already exists
   SELECT COUNT(*) INTO @cityExists FROM city WHERE cname = cityName COLLATE utf8mb4_general_ci;

   -- If the city doesn't exist, insert it into the city table
   IF @cityExists = 0 THEN
        -- Calculate the next city ID based on existing data
        SET @newCityID = (SELECT CONCAT('C', LPAD(MAX(CONVERT(SUBSTRING(cid, 2), SIGNED)) + 1, 2, '0')) FROM city);

        -- Insert the new city into the city table
        INSERT INTO city (cid, sid, cname) VALUES (@newCityID, (SELECT sid FROM state WHERE sname = stateName COLLATE utf8mb4_general_ci), cityName);
   END IF;

   -- Calculate the next property ID
   SET newPid = (SELECT CONCAT('PR', LPAD(MAX(CONVERT(SUBSTRING(pid, 3), SIGNED)) + 1, 2, '0')) FROM property);

   -- Insert the new property with the generated pid
   INSERT INTO property (pid, uid, cid, aid, title, `description`, bedrooms, size, `type`, price)
   VALUES (newPid, userID, (SELECT cid FROM city WHERE cname = cityName COLLATE utf8mb4_general_ci), agentID, propTitle, propDescription, propBedrooms, propSize, propType, propPrice);

   COMMIT;
END;
//
DELIMITER ;


-- Buy/Sell Properties

DELIMITER //
CREATE PROCEDURE BuySellProperty(IN propertyID VARCHAR(4))
BEGIN
    DELETE FROM property WHERE pid = propertyID COLLATE utf8mb4_general_ci;
    COMMIT;
END;
//
DELIMITER ;
