<?php

class DevHelper_XenForo_ControllerAdmin_AdminTemplateModification extends XFCP_DevHelper_XenForo_ControllerAdmin_AdminTemplateModification
{
	public function actionIndex()
	{
		$response = parent::actionIndex();

		if ($response instanceof XenForo_ControllerResponse_View)
		{
			$addOns = &$response->params['addOns'];
			$groupedModifications = &$response->params['groupedModifications'];

			$this->getHelper('DevHelper_ControllerHelper_AddOn')->filterKeepActiveAddOns($groupedModifications, $addOns);
		}

		return $response;
	}

}