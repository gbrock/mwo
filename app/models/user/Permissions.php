<?php

class Permissions {
	public static function getAll()
	{
		$groups = Sentry::findAllGroups();
		$permissions = array();

		if(count($groups))
		{
			foreach($groups as $g)
			{
				if(count($g->permissions))
				{
					foreach($g->permissions as $name => $allowed)
					{
						$permissions[] = $name;
					}
				}
			}
		}

		return array_unique($permissions);
	}
}
