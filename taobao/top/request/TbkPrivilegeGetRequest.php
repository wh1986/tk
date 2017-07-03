<?php
/**
 * TOP API: taobao.tbk.item.info.get request
 * 
 * @author auto create
 * @since 1.0, 2016.01.05
 */
class TbkPrivilegeGetRequest 
{
	/** 
	 * 需返回的字段列表
	 **/
	private $item_id;
	private $adzone_id;
	private $platform;
	private $site_id;
	private $me;
	
	private $apiParas = array();
	
	public function setItemId($item_id)
	{
		$this->item_id = $item_id;
		$this->apiParas["item_id"] = $item_id;
	}

	public function setAdZoneId($adzone_id)
	{
		$this->adzone_id = $adzone_id;
		$this->apiParas["adzone_id"] = $adzone_id;
	}

	public function setPlatform($platform)
	{
		$this->platform = $platform;
		$this->apiParas["platform"] = $platform;
	}

	public function setSiteId($site_id)
	{
		$this->site_id = $site_id;
		$this->apiParas["site_id"] = $site_id;
	}

	public function getPlatform()
	{
		return $this->platform;
	}

	public function getApiMethodName()
	{
        return "taobao.tbk.privilege.get";
	}
	
	public function getApiParas()
	{
		return $this->apiParas;
	}
	
	public function check()
	{
		RequestCheckUtil::checkNotNull($this->fields,   "item_id");
		RequestCheckUtil::checkNotNull($this->numIids,  "adzone_id");
		RequestCheckUtil::checkNotNull($this->numIids,  "site_id");
	}
	
	public function putOtherTextParam($key, $value) {
		$this->apiParas[$key] = $value;
		$this->$key = $value;
	}
}
