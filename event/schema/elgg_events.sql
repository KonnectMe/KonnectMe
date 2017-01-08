
-- 
-- Table structure for table `elgg_causes`
-- 

CREATE TABLE `elgg_causes` (
  `guid` bigint(20) NOT NULL,
  `owner_guid` bigint(20) NOT NULL,
  `event_guid` bigint(20) NOT NULL,
  `group_guid` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `brief_description` text,
  `icon_time` int(11) DEFAULT NULL,
  `campaign_end_date` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT '0',
  `goal` int(1) DEFAULT '0',
  `time_created` int(11) NOT NULL,
  `access_id` int(11) NOT NULL DEFAULT '2',
  `tags` text,
  PRIMARY KEY (`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `elgg_causes_amount_structure`
-- 

CREATE TABLE `elgg_causes_amount_structure` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `cause_guid` bigint(20) NOT NULL,
  `amount` int(11) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=546 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `elgg_event`
-- 

CREATE TABLE `elgg_event` (
  `guid` bigint(20) NOT NULL,
  `owner_guid` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` longtext,
  `brief_description` longtext,
  `icon_time` int(11) DEFAULT NULL,
  `start_date` int(11) NOT NULL,
  `end_date` int(11) NOT NULL,
  `category` varchar(255) DEFAULT NULL,
  `venue` varchar(255) DEFAULT NULL,
  `location` varchar(255) DEFAULT NULL,
  `related_event_guid` int(11) DEFAULT '0',
  `fundraising` int(1) DEFAULT '0',
  `isfree` int(1) DEFAULT '0',
  `blocked` int(1) DEFAULT '0',
  `paypal` varchar(255) DEFAULT NULL,
  `time_created` int(11) NOT NULL,
  `access_id` int(11) NOT NULL DEFAULT '2',
  `tags` text,
  PRIMARY KEY (`guid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

-- 
-- Table structure for table `elgg_events_customforms`
-- 

CREATE TABLE `elgg_events_customforms` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event_guid` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `type` int(11) NOT NULL,
  `default_values` text NOT NULL,
  `required` int(1) NOT NULL DEFAULT '0',
  `item_order` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=31 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `elgg_events_purchase_info`
-- 

CREATE TABLE `elgg_events_purchase_info` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `user_guid` bigint(20) NOT NULL,
  `event_guid` int(11) DEFAULT '0',
  `ticket_guid` bigint(20) NOT NULL,
  `group_guid` bigint(20) NOT NULL,
  `time_created` int(11) NOT NULL,
  `status` int(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2354 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `elgg_events_purchase_userinfo`
-- 

CREATE TABLE `elgg_events_purchase_userinfo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `purchase_guid` bigint(20) NOT NULL,
  `form_guid` int(11) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=23489 ;

-- --------------------------------------------------------

-- 
-- Table structure for table `elgg_events_tickets`
-- 

CREATE TABLE `elgg_events_tickets` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `event_guid` bigint(20) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `price` int(11) NOT NULL,
  `seats` int(11) NOT NULL,
  `sold` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=11 ;
