<?php

/*                                                                      *
 *  COPYRIGHT NOTICE                                                    *
 *                                                                      *
 *  (c) 2010 Martin Helmich <m.helmich@mittwald.de>                     *
 *           Mittwald CM Service GmbH & Co KG                           *
 *           All rights reserved                                        *
 *                                                                      *
 *  This script is part of the TYPO3 project. The TYPO3 project is      *
 *  free software; you can redistribute it and/or modify                *
 *  it under the terms of the GNU General Public License as published   *
 *  by the Free Software Foundation; either version 2 of the License,   *
 *  or (at your option) any later version.                              *
 *                                                                      *
 *  The GNU General Public License can be found at                      *
 *  http://www.gnu.org/copyleft/gpl.html.                               *
 *                                                                      *
 *  This script is distributed in the hope that it will be useful,      *
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of      *
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the       *
 *  GNU General Public License for more details.                        *
 *                                                                      *
 *  This copyright notice MUST APPEAR in all copies of the script!      *
 *                                                                      */



	/**
	 *
	 * Repository class for forum objects.
	 *
	 * @author     Martin Helmich <m.helmich@mittwald.de>
	 * @package    MmForum
	 * @subpackage Domain_Repository_Forum
	 * @version    $Id$
	 *
	 * @copyright  2010 Martin Helmich <m.helmich@mittwald.de>
	 *             Mittwald CM Service GmbH & Co. KG
	 *             http://www.mittwald.de
	 * @license    GNU Public License, version 2
	 *             http://opensource.org/licenses/gpl-license.php
	 *
	 */

Class Tx_MmForum_Domain_Repository_Forum_ForumRepository Extends Tx_Extbase_Persistence_Repository {


	protected $authenticationService = NULL;
	
	public function injectAuthenticationService(Tx_MmForum_Service_Authentication_AuthenticationServiceInterface $authenticationService) {
		$this->authenticationService = $authenticationService;
	}

		/**
		 *
		 * Finds all forums for the index view.
		 *
		 * @return Array<Tx_MmForum_Domain_Model_Forum_Forum>
		 *                             All forums for the index view.
		 *
		 */

	Public Function findForIndex() { Return $this->findRootForums(); }



		/**
		 *
		 * Finds all root forums.
		 *
		 * @return Array<Tx_MmForum_Domain_Model_Forum_Forum>
		 *                             All forums for the index view.
		 *
		 */

	Public Function findRootForums() {
		$query = $this->createQuery();
		$result = $query->matching($query->equals('forum', array(NULL,0)))
			->execute();
		return $this->filterByAccess($result, 'read');
	}
	
	protected function filterByAccess(Iterator $objects, $action='read') {
		$result = array();
		foreach($objects as $forum) {
			if($this->authenticationService->checkAuthorization($forum, $action))
				$result[] = $forum;
		} return $result;
	}

}
?>