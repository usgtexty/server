<?php

namespace OCP\Circles\Model;

interface ICircle {
	public const TYPE_SINGLE = 0;
	public const TYPE_USER = 1;
	public const TYPE_GROUP =2;
	public const TYPE_MAIL = 4;
	public const TYPE_CONTACT = 8;
	public const TYPE_CIRCLE = 16;
	public const TYPE_APP = 10000;

}
